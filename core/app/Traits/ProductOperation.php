<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Tax;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;

trait ProductOperation
{
    public function list()
    {
        $pageTitle = "Manage Product";
        $view      = "Template::user.product.list";
        $user      = getParentUser();

        $baseQuery = Product::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->trashFilter()
            ->with(['details:id,product_id,final_price', 'category:id,name', 'brand:id,name'])
            ->searchable(['product_code', 'name', "details:sku", 'category:name', 'brand:name', 'unit:name']);

        if (request()->export) {
            return exportData($baseQuery, request()->export, "Product");
        }

        $products = $baseQuery->paginate(getPaginate());
        return responseManager("products", $pageTitle, 'success', compact('products', 'view', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Add Product";
        $view      = "Template::user.product.add";
        extract($this->basicDataForProductOperation());
        return responseManager("add_product", $pageTitle, 'success', compact('pageTitle', 'categories', 'units', 'brands', 'taxes', 'attributes', 'view'));
    }

    public function edit($id)
    {
        $pageTitle = "Edit Product";
        $user      = getParentUser();
        $view      = "Template::user.product.edit";
        $product   = Product::where('user_id', $user->id)->with('details.attribute', 'details.variant', 'details', 'details.tax')->where('id', $id)->firstOrFailWithApi('product');
        extract($this->basicDataForProductOperation());
        return responseManager("edit_product", $pageTitle, 'success', compact('pageTitle', 'categories', 'units', 'brands', 'taxes', 'attributes', 'view', 'product'));
    }

    public function view($id)
    {
        $pageTitle = "View Product";
        $user      = getParentUser();
        $view      = "Template::user.product.view";
        $product   = Product::where('user_id', $user->id)->with('details.attribute', 'details.variant', 'details', 'details.tax', 'category', 'brand', 'unit')->where('id', $id)->firstOrFailWithApi('product');
        return responseManager("view_product", $pageTitle, 'success', compact('pageTitle', 'product', 'view'));
    }

    public function search()
    {
        $search      = request()->search;
        $search      = "%$search%";
        $user        = getParentUser();
        $searchQuery = ProductDetail::where('user_id', $user->id)->where('sku', request()->search);
        $exactMatch  = true;

        if (!(clone $searchQuery)->count()) {
            $searchQuery->orWhereHas('product', function ($q) use ($search, $user) {
                $q->where('user_id', $user->id)->where(function ($productQuery) use ($search) {
                    $productQuery->where('sku', "like", $search)
                        ->orWhere('product_code', "like", $search)
                        ->orWhere('name', "like", $search);
                });
            });
            $exactMatch = false;
        }

        if (request()->warehouse_id) {
            $searchQuery->withSum(['productStock' => function ($q) {
                $q->where('warehouse_id', request()->warehouse_id);
            }], 'stock');
        }

        $productDetails = $searchQuery->with([
            'product',
            'attribute',
            'variant',
        ])->take(20)->get();

        $products  = formattedProductDetails($productDetails);
        $message[] = "product search results";

        return jsonResponse('product_search', 'success', $message, [
            'products'    => $products,
            'exact_match' => $exactMatch,
        ]);
    }

    public function generateProductCode()
    {
        $code      = $this->getProductCode();
        $message[] = "Auto generate product code";
        return jsonResponse('code', 'success', $message, [
            'code' => $code,
        ]);
    }

    private function getProductCode()
    {
        $user            = getParentUser();
        $maxId           = Product::where('user_id', $user->id)->count() + 1;
        $prefix          = gs('prefix_setting',  $user->id, true);
        $summationNumber = 1000;

        if ($prefix) {
            return $prefix->product_code_prefix . ($summationNumber + $maxId);
        } else {
            return $summationNumber + $maxId;
        }
    }
    public function status($id)
    {
        return Product::changeStatus($id);
    }

    public function save(Request $request)
    {

        $user = getParentUser();

        if (!featureAccessLimitCheck($user->product_limit)) {
            $message = "You have reached the maximum limit of adding product. Please upgrade your plan.";
            return responseManager("subscription_reached", $message, "error");
        }

        $validator = $this->validation($request);

        if ($validator->fails()) {
            return jsonResponse('validation_error', 'error', $validator->errors()->all());
        }

        $productCode = $request->product_code ?? $this->getProductCode();
        try {

            DB::beginTransaction();

            $product               = new Product();
            $product->user_id      = $user->id;
            $product->name         = $request->name;
            $product->product_code = $productCode;
            $product->product_type = $request->product_type;
            $product->category_id  = $request->category_id;
            $product->unit_id      = $request->unit_id;
            $product->brand_id     = $request->brand_id;
            $product->description  = $request->description ?? null;

            if ($request->hasFile('image')) {
                try {
                    $path           = getFilePath('product') . "/" . $productCode;
                    $product->image = fileUploader($request->image, $path);
                } catch (\Exception $exp) {
                    $message[] = "Couldn\'t upload your image";
                    return jsonResponse('exception', 'error', $message);
                }
            }

            $product->save();

            $productDetails = [];

            foreach ($request->product_detail as $k => $detail) {
                $sku              = $this->generateProductSku($detail, $product, $k + 1);
                $productDetails[] = array_merge(makeProductDetails($detail), [
                    'product_id'     => $product->id,
                    'user_id'        => $user->id,
                    'variant_id'     => $detail['variant_id'] ?? 0,
                    'attribute_id'   => $detail['attribute_id'] ?? 0,
                    'alert_quantity' => $detail['alert_quantity'],
                    'sku'            => $sku,
                    'barcode_html'   => generateBarcodeHtml($sku),
                ]);
            }

            ProductDetail::insert($productDetails);
            decrementFeature($user, 'product_limit');
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            $message[] = $ex->getMessage();
            adminActivity("product", get_class($product), $product->id, "Try the product add but failed for: " . $ex->getMessage());
            return jsonResponse('exception', 'error', $message);
        }

        adminActivity("product-add", get_class($product), $product->id);
        $message[] = "Product added successfully";
        return jsonResponse('product', 'success', $message);
    }

    public function importProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => ['required', 'file', 'max:2048', 'mimes:csv,xlsx'],
        ]);

        if ($validator->fails()) {
            return jsonResponse('validation_error', 'error', $validator->errors()->all());
        }

        $user = getParentUser();

        if (!featureAccessLimitCheck($user->product_limit)) {
            $message = "You have reached the maximum limit of adding product. Please upgrade your plan.";
            return jsonResponse("subscription_reached", "error", [$message]);
        }

        $columnNames = [
            'name',
            'product_code',
            'category',
            'brand',
            'unit',
            'description',
            'sku',
            'base_price',
            'profit_margin',
            'tax_name',
            'tax_type',
            'tax_percentage',
            'discount_type',
            'discount_value',
            'alert_quantity',
        ];


        DB::beginTransaction();

        try {

            $spreadsheet = IOFactory::load($request->file);
            $data        = $spreadsheet->getActiveSheet()->toArray();

            if (count($data) <= 0) {
                return jsonResponse("product_import", "error", [
                    "The uploaded file is empty. Please upload a valid file with product data."
                ]);
            }

            if (count($data[0]) != 15) {
                return jsonResponse("product_import", "error", [
                    "The uploaded file format is invalid. The number of columns does not match the required sample file structure."
                ]);
            }

            if ($columnNames !== $data[0]) {
                return jsonResponse("product_import", "error", [
                    "The column names in the uploaded file do not match the required sample file format. Please use the provided sample file."
                ]);
            }

            unset($data[0]);

            if (count($data) > $user->product_limit && $user->product_limit != Status::UNLIMITED) {
                return jsonResponse("product_import", "error", [
                    "Product import limit exceeded.",
                    "Remaining product limit: {$user->product_limit}. Attempted import: " . count($data)
                ]);
            }


            $productDetails = [];
            $totalImportedProducts = 0;

            foreach ($data as $key => $item) {

                $productName   = $item[0];
                $productCode   = empty($item[1]) || is_null($item[1]) ? null : $item[1];
                $categoryName  = $item[2];
                $brandName     = $item[3];
                $unitName      = $item[4];
                $description   = $item[5];
                $sku           = empty($item[6]) || is_null($item[6]) ? null : $item[6];
                $basePrice     = $item[7];
                $profitMargin  = $item[8];
                $taxName       = $item[9] ?? null;
                $taxType       = $item[10] ?? null;
                $taxPercentage = $item[11] ?? null;
                $discountType  = $item[12];
                $discountValue = $item[13];
                $alertQuantity = $item[14];

                if (!$productName) {
                    DB::rollBack();
                    return  jsonResponse("product_import", "error", ["The product name is missing from the file row $key "]);
                }

                if (!$description) {
                    DB::rollBack();
                    return  jsonResponse("product_import", "error", ["The product description is missing from the file row $key "]);
                }

                if (!$categoryName) {
                    DB::rollBack();
                    return  jsonResponse("product_import", "error", ["The category name is missing from the file row $key "]);
                }

                if (!$brandName) {
                    DB::rollBack();
                    return  jsonResponse("product_import", "error", ["The brand name is missing from the file row $key "]);
                }

                if (!$unitName) {
                    DB::rollBack();
                    return  jsonResponse("product_import", "error", ["The unit name is missing from the file row $key "]);
                }

                if (getAmount($basePrice) <= 0) {
                    DB::rollBack();
                    return  jsonResponse("product_import", "error", ["The base price must be greater than 0 from the file row $key"]);
                }

                if (!$productCode) {
                    $productCode = $this->getProductCode();
                }

                $productExists = Product::where('user_id', $user->id)->where(function ($q) use ($productName, $productCode) {
                    $q->where('product_code', $productCode)->orWhere('name', $productName);
                })->exists();

                if ($productExists) {
                    DB::rollBack();
                    return  jsonResponse("product_import", "error", ["Duplicate product found in the file row $key "]);
                };


                $category = Category::firstOrCreate([
                    'user_id' => $user->id,
                    'name'    => $categoryName
                ]);

                $brand = Brand::firstOrCreate([
                    'user_id' => $user->id,
                    'name'    => $brandName
                ]);

                $unit = Unit::firstOrCreate([
                    'user_id' => $user->id,
                    'name'    => $unitName
                ], [
                    'short_name' => $unitName
                ]);

                if ($taxName && $taxPercentage) {
                    $tax = Tax::firstOrCreate(
                        [
                            'user_id' => $user->id,
                            'name'    => $taxName
                        ],
                        [
                            'percentage' => $taxPercentage
                        ]
                    );
                }

                $product               = new Product();
                $product->user_id      = $user->id;
                $product->name         = $productName;
                $product->product_code = $productCode;
                $product->product_type = Status::PRODUCT_TYPE_STATIC;
                $product->category_id  = $category->id;
                $product->unit_id      = $unit->id;
                $product->brand_id     = $brand->id;
                $product->description  = $description;
                $product->save();


                $productDetails[] = array_merge(makeProductDetails([
                    'base_price'    => $basePrice,
                    'tax_type'      => match ($taxType) {
                        'inclusive' => Status::TAX_TYPE_EXCLUSIVE,
                        'exclusive' => Status::TAX_TYPE_INCLUSIVE,
                        default     => 0
                    },
                    'profit_margin' => $profitMargin,
                    'discount_type' => $discountType,
                    'discount'      => $discountValue,
                    'tax_id'        => $tax ? $tax->id : 0
                ]), [
                    'product_id'     => $product->id,
                    'user_id'        => $user->id,
                    'variant_id'     => 0,
                    'alert_quantity' => $alertQuantity,
                    'sku'            => $sku ?? $productCode,
                    'barcode_html'   => generateBarcodeHtml($sku ?? $productCode),
                ]);

                $totalImportedProducts++;
            }

            if (!empty($productDetails)) {
                ProductDetail::insert($productDetails);
            }

            decrementFeature($user, 'product_limit', $totalImportedProducts);

            DB::commit();
            return jsonResponse("product_import", "success", ["Total imported $totalImportedProducts products successfully."]);
        } catch (Exception $ex) {
            DB::rollBack();
            $message = $ex->getMessage() ?? "Something went wrong, please try again later.";
            return jsonResponse("product_import", "error", [$message]);
        }
    }

    public function downloadCsv()
    {
        $filePath = "assets/file/sample_file/product_import_sample.csv";

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        return responseManager("not_found", "File not found", "error");
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validation($request, $id);

        if ($validator->fails()) {
            return jsonResponse('validation_error', 'error', $validator->errors()->all());
        }

        $user = getParentUser();
        try {
            DB::beginTransaction();

            $product = Product::where('user_id', $user->id)->find($id);

            if (!$product) {
                $message[] = "Product not found";
                return jsonResponse('not_found', 'error', $message);
            }

            $product->name        = $request->name;
            $product->category_id = $request->category_id;
            $product->unit_id     = $request->unit_id;
            $product->brand_id    = $request->brand_id;
            $product->description = $request->description ?? null;

            if ($request->hasFile('image')) {
                try {
                    $path           = getFilePath('product') . "/" . $product->product_code;
                    $product->image = fileUploader($request->image, $path, old: $product->image);
                } catch (\Exception $exp) {
                    $message[] = "Couldn\'t upload your image";
                    return jsonResponse('exception', 'error', $message);
                }
            }

            $product->save();
            $productDetails = [];

            foreach ($request->product_detail as $k => $detail) {
                $makeProductDetails = makeProductDetails($detail);
                if (array_key_exists('id', $detail)) {
                    $productDetail = ProductDetail::where('id', $detail['id'])->first();
                    if (!$productDetail) {
                        throw new Exception("The product is not found");
                    }
                    $productDetail->update(array_merge($makeProductDetails, ['alert_quantity' => $detail['alert_quantity']]));
                } else {
                    $productDetails[] = array_merge($makeProductDetails, [
                        'product_id'     => $product->id,
                        'variant_id'     => $detail['variant_id'] ?? 0,
                        'attribute_id'   => $detail['attribute_id'] ?? 0,
                        'sku'            => $this->generateProductSku($detail, $product, $k + 1),
                        'alert_quantity' => $detail['alert_quantity'],
                    ]);
                }
            }

            ProductDetail::insert($productDetails);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            $message[] = $ex->getMessage();
            adminActivity("product", get_class($product), $product->id, "Try the product update but failed for: " . $ex->getMessage());
            return jsonResponse('exception', 'error', $message);
        }

        adminActivity("product-updated", get_class($product), $product->id);
        $message[] = "Product update successfully";
        return jsonResponse('product', 'success', $message);
    }

    private function validation($request, $id = 0)
    {
        $isRequired = $id ? 'nullable' : 'required';

        $validator = Validator::make($request->all(), [
            'name'                            => ["required", Rule::unique('products', 'name')->where('user_id', getParentUser()->id)->ignore($id)],
            'brand_id'                        => "required|integer|exists:brands,id",
            'unit_id'                         => "required|integer|exists:units,id",
            'category_id'                     => "required|integer|exists:categories,id",
            'product_code'                    => ["nullable", Rule::unique('products', 'product_code')->where('user_id', getParentUser()->id)->ignore($id)],
            "product_type"                    => [$isRequired, Rule::in(Status::PRODUCT_TYPE_STATIC, Status::PRODUCT_TYPE_VARIABLE)],
            'image'                           => "nullable|image",
            'description'                     => "nullable|string",

            'product_detail'                  => 'required|array|min:1',
            "product_detail.*.id"             => "nullable|exists:product_details,id",
            "product_detail.*.sku"            => ["nullable", Rule::unique('product_details', 'sku')->where('user_id', getParentUser()->id)->ignore($id)],
            "product_detail.*.base_price"     => "required|numeric|gt:0",
            "product_detail.*.tax_id"         => "nullable|integer|exists:taxes,id",
            "product_detail.*.tax_type"       => ["nullable", Rule::in(Status::TAX_TYPE_EXCLUSIVE, Status::TAX_TYPE_INCLUSIVE)],
            "product_detail.*.purchase_price" => "required|numeric|gt:0",
            "product_detail.*.sale_price"     => "required|numeric|gt:0",
            "product_detail.*.profit_margin"  => "required|numeric|gte:0",
            "product_detail.*.discount_type"  => ["nullable", Rule::in(Status::DISCOUNT_PERCENT, Status::DISCOUNT_FIXED)],
            "product_detail.*.discount_value" => "nullable|numeric|gt:0",
            "product_detail.*.alert_quantity" => "required|numeric|gte:0",

            "product_detail.*.variant_id"     => "nullable|exists:variants,id",
            "product_detail.*.attribute_id"   => "nullable|exists:attributes,id",
        ], [
            'product_detail.*.alert_quantity.required' => "All the alert quantity field is required",
        ]);

        return $validator;
    }

    private function basicDataForProductOperation()
    {
        $user = getParentUser();

        return
            [
                'categories' => Category::where('user_id', $user->id)->active()->get(),
                'brands'     => Brand::where('user_id', $user->id)->active()->get(),
                'units'      => Unit::where('user_id', $user->id)->active()->get(),
                'taxes'      => Tax::where('user_id', $user->id)->active()->get(),
                'attributes' => Attribute::where('user_id', $user->id)->active()->with('variants', function ($q) {
                    $q->active();
                })->get(),
            ];
    }

    private function generateProductSku($requestProductDetail, $product, $k)
    {
        if (array_key_exists('sku', $requestProductDetail) && !is_null($requestProductDetail['sku'])) {
            return $requestProductDetail['sku'];
        };

        if ($product->product_type == Status::PRODUCT_TYPE_STATIC) {
            return $product->product_code;
        }

        return $product->product_code . "-" . $k;
    }
}
