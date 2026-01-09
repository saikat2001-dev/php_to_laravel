<?php
//function
function calculateTotalPrice($num1, $num2): int{
  $result = $num1 + $num2;
  return $result;
}

//condition
$a = 10;
if($a < 5) {
  echo "Smaller";
}
else if($a > 10) {
  echo "Greater";
}
else {
  echo $a;
}
echo "<br>";

//loops
$arr = array("Phone", "TV", "Earbuds", "Chair", "RAM");
foreach($arr as $value){
  echo "$value";
  echo "<br>";
}
?>