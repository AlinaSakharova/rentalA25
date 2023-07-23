<?php
require_once 'sdbh.php';
class form
{
    /**Search for rental prices depending on the number of days
     * @param $tariffes - associative array of the form number of days -> cost
     * @return $cost - rental price
     */
    public function search_cost_of_tariff($tariffes)
    {
        $cost = 0;
        foreach (array_reverse(array_keys($tariffes)) as $value){
            if ($_POST['days']>= $value)
            {
                $cost = intval($tariffes[$value]);
                break;
            }
        }
        return $cost;
    }

    /**Final calculation of the cost, including additional. services
     * @param $products - associative array with product data (ID, NAME, PRICE, TARIFF)
     *@return $total - total cost with additional services
     */
    public function final_calculation($products)
    {
        $product = $products[intval($_POST['product'])-1];
        if ($product['TARIFF'] != null){
            $tariffes = unserialize($product['TARIFF']);
            $cost = $this->search_cost_of_tariff($tariffes);
        }
        else{
            $cost = $product['PRICE'];
        }
        $days = $_POST['days'];
        $total = 0;
        if (isset($_POST['services'])){
           foreach ($_POST['services'] as $value)
           {
               if ($value != 0)
               {
                   $services = $value * $days;
                   $total += $services;
               }
           }
        }
        $total += $cost * $days;;
        return $total;
    }

    /**
     *The main function accesses the database and prepares the array. Prints JSON for output on the client
     */
    public function main()
    {
        $dbh = new sdbh();
        if(isset($_POST['days']) and $_POST['days'] != 0)
        {
            $products = $dbh->mselect_cols('a25_products','ID', 'NAME', 'PRICE', 'TARIFF', 'id');
            //Избавились от дырки в  массиве
            $prod = array();
            foreach ($prod as $key => $value)
            {
                $val1=key($value);
                $val2=current($value);
                $prod[$val1]=$val2;
            }
            $total = array("total" => $this->final_calculation($products));
        }
        echo json_encode($total);
    }
}
$formm = new form();
$formm->main();
?>