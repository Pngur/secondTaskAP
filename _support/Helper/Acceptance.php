<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module {
   public function collectData ($a1, $a2, $a3) {

      for ($i = 0;  $i < count($a1); $i++) {
         $res[] = [$a1[$i], $a2[$i], $a3[$i]];
      }
      return $res;
   }

   public function saveCSVReport ($data, $file_name) {
      $fp = fopen("./tests/{$file_name}.csv", 'w+');
         foreach($data as $k) {
            fputcsv($fp, $k, "\n");
         }
      fclose($fp);   
   }
   public function getCurrentUrl () {
      return $this->getModule('WebDriver')->_getUrl().$this->getModule('WebDriver')->_getCurrentUri();
   }

   public function compareResults ($expected, $actual) {
      $result = [];
      for ($i = 0; $i < count($expected); $i++) {
         if ($expected[$i] !== $actual[$i]) {
            array_push($result, ["EXPECTED:{$expected[$i]}", "ACTUAL:{$actual[$i]}", 'RESULT: FAIL']);
         } else {
            array_push($result, ["EXPECTED:{$expected[$i]}", "ACTUAL:{$actual[$i]}", 'RESULT: TRUE']);
         }
      }
     return $result;
   }
}