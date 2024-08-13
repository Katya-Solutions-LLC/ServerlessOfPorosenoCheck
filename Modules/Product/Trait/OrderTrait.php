<?php

namespace Modules\Product\Trait;

use App\Jobs\BulkNotification;

trait OrderTrait
{
 

    protected function sendNotificationOnOrderUpdate($type, $order)
    {
        $data = mail_footer($type, $order);

        $data['order'] = $order;
      
        BulkNotification::dispatch($data);
    }


    function generateCombinations($arrays, $currentIndex = 0, $currentCombination = [])
    {
        if ($currentIndex == count($arrays)) {
            return [$currentCombination];
        }
    
        $result = [];
        foreach ($arrays[$currentIndex] as $value) {
            $nextCombination = array_merge($currentCombination, [$value]);
            $result = array_merge($result, generateCombinations($arrays, $currentIndex + 1, $nextCombination));
        }
    
        return $result;
    }
  
}
