<?php

namespace App\Http\Middleware;

use App\Models\SubscriptionPlan;
use Closure;
use Illuminate\Http\Request;

class InjectWhatsappUpgradeUI
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$request->is('user/subscription/*')) return $response;

        $user = auth()->user();
        if (!$user) return $response;

        $currentPlanId = $user->plan_id ?? 0;
        $higherPlans = SubscriptionPlan::where('status', 1)
            ->where('id', '>', $currentPlanId)
            ->orderBy('id')->get(['id', 'name', 'monthly_price'])->toArray();

        if (empty($higherPlans)) return $response;

        $content = $response->getContent();
        if (!is_string($content) || !str_contains($content, '</body>')) return $response;

        $nextPlan    = $higherPlans[0];
        $nextPlanId  = (int) $nextPlan['id'];
        $upgradeUrl  = url('/user/whatsapp/upgrade/' . $nextPlanId);
        $plansJson   = json_encode($higherPlans, JSON_UNESCAPED_UNICODE);
        $baseUpgrade = url('/user/whatsapp/upgrade');

        $script = "<script id='wa-upgrade-injector'>
(function(){
    var nextPlanId={$nextPlanId};
    var upgradeUrl='{$upgradeUrl}';
    var baseUpgrade='{$baseUpgrade}';
    var higherPlans={$plansJson};

    function injectSubscriptionTabBtn(){
        var bottom=document.querySelector('.active-card__bottom');
        var renew=bottom?bottom.querySelector('.purchaseBtn'):null;
        if(!renew||document.querySelector('.wa-upgrade-btn-sub'))return;

        var btn=document.createElement('a');
        btn.className='btn btn-large w-100 wa-upgrade-btn-sub mt-2';
        btn.href=upgradeUrl;
        btn.style.cssText='background:linear-gradient(135deg,#25D366 0%,#128C7E 100%);color:#fff;font-weight:700;border:none;padding:.85rem;border-radius:.5rem;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.5rem;transition:all .25s;box-shadow:0 4px 12px rgba(37,211,102,.3);';
        btn.innerHTML='<i class=\"las la-rocket\"></i><span>ترقية الباقة</span>';
        btn.onmouseover=function(){this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(37,211,102,.5)';};
        btn.onmouseout=function(){this.style.transform='';this.style.boxShadow='0 4px 12px rgba(37,211,102,.3)';};
        bottom.appendChild(btn);
    }

    function injectPlansTabBtns(){
        var planCards=document.querySelectorAll('#pills-plans .card, [data-bs-target=\"#pills-plans\"] .card, .pricing-card, .plan-card');
        higherPlans.forEach(function(plan){
            document.querySelectorAll('button.purchaseBtn, .btn--primary').forEach(function(buyBtn){
                var card=buyBtn.closest('.card, .pricing-card, .plan-card, .col');
                if(!card||card.querySelector('.wa-upgrade-btn-plan-'+plan.id))return;
                var cardText=card.textContent||'';
                if(cardText.indexOf(plan.name)===-1)return;
                if(buyBtn.classList.contains('wa-upgrade-btn-sub'))return;

                var upBtn=document.createElement('a');
                upBtn.className='btn w-100 mt-2 wa-upgrade-btn-plan-'+plan.id;
                upBtn.href=baseUpgrade+'/'+plan.id;
                upBtn.style.cssText='background:linear-gradient(135deg,#16a34a 0%,#15803d 100%);color:#fff;font-weight:700;border:none;padding:.65rem;border-radius:.5rem;text-decoration:none;display:flex;align-items:center;justify-content:center;gap:.4rem;font-size:.9rem;';
                upBtn.innerHTML='<i class=\"las la-arrow-up\"></i><span>ترقية</span>';
                buyBtn.parentElement.appendChild(upBtn);
            });
        });
    }

    function inject(){
        try{injectSubscriptionTabBtn();}catch(e){}
        try{injectPlansTabBtns();}catch(e){}
    }

    if(document.readyState==='loading'){
        document.addEventListener('DOMContentLoaded',inject);
    }else{ inject(); }
    setTimeout(inject,500);
    setTimeout(inject,1500);
    document.addEventListener('shown.bs.tab',inject);
})();
</script>";

        $content = str_replace('</body>', $script . '</body>', $content);
        $response->setContent($content);
        return $response;
    }
}
