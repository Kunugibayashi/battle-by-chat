<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

use Cake\Core\Configure;

class DiceComponent extends Component
{
    /**
     * ダイスフォーマットのチェック
     */
    public function isDiceFormat($diceString)
    {
        $pattern = '/^([0-9]{1,})d([0-9]{1,})$/';
        if (preg_match($pattern, $diceString)) {
            return true;
        }
        return false;
    }

    /**
     * ダイスをふる
     */
     public function roll($diceString) {
         $pieces = explode("d", $diceString);
         $count = $pieces[0];
         $surface = $pieces[1];
         if ($count > 10) {
             $count = 10;
         }
         if ($surface > 100) {
             $surface = 100;
         }
         list($surfaces, $sum) = $this->dice($count, $surface);
         return [$count.'d'.$surface , $surfaces, $sum];
     }

     /**
      * ダイス
      */
     public function dice($count, $surface) {
         $surfaces = array();
         $sum = 0;

         for ($i=0; $i < $count; $i++) {
             $spot = rand(1, $surface);
             $surfaces[$i] = $spot;
             $sum += $spot;
         }
         return [$surfaces, $sum];
     }
}
