<p id="tickets-data">
<div class="ticketContainer">
    <div class="game_title">
        <img class="logo" src="assets/static/logo/rajashriPrint.png" alt=""/>
    </div>
    <div class="lotteryname">Samruddhi Lottery</div>
    <div class="drawTime">
        <?php
        $date = new \DateTime($row["gameendtime"]);
        $drtime = date_format($date, 'G:iA');
        echo "Dr. {$row["gametimeid"]}  {$row["enterydate"]} {$drtime}"
        ?>
    </div>
    <table class="numbers-played">
        <tbody>
            <tr><th> Number </th> <th> Qty </th><th> Number </th> <th> Qty </th><th> Number </th> <th> Qty </th></tr>
        </tbody>
        <tbody class="numbers-played-data">
            <?php
            $limit = 1;
            $json = json_decode($row["point"], true);
            foreach ($json as $key1 => $val1) {
                foreach ($val1 as $key => $val) {
                    if ($limit == 1) {
                        echo "<tr>";
                    }
                    if ($limit == 3) {
                        echo "<td> {$key} </td> <td> {$val} </td></tr>";
                        $limit = 0;
                    } else {
                        echo "<td> {$key} </td> <td> {$val} </td>";
                    }
                    $limit++;
                }
            }
            ?>
        </tbody>
    </table>
    <div>
        Per ticket price .<span class="perTickt"> 2 . 00</span>
    </div>
    <div>
        total Rs. <span class="amount"><?= $row["amount"] ?></span>
    </div>
    <div class="normal_font">
        Qty. 
        <span class="qty"><?= $row["totalpoint"] ?></span>
        <span class="platTime"><?= $row["isDate"] ?></span>
    </div>
    <div id="barcode"></div>
    <div>
        <div class="pull-left transactionId">
            <?= $row["id"] ?>
            ||
            Retailer Code
            <span class="retailer_code">
                <?= $row["own"] ?>
            </span>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsbarcode/3.11.0/JsBarcode.all.min.js" integrity="sha256-BjqnfACYltVzhRtGNR2C4jB9NAN0WxxzECeje7/XpwE=" crossorigin="anonymous"></script>
    <script>
//        JsBarcode("#barcode", "<?php echo $row["game"]; ?>", {
//            height: 40,
//            width: 1,
//            displayValue: true
//        });
        $(document).ready(function(){
            $("#barcode").html("<img style='width:50%; heigt:100px;' src='"+textToBase64Barcode('<?=$row["game"]?>')+"'>");
        });

        function textToBase64Barcode(text) {
            var canvas = document.createElement("canvas");
            JsBarcode(canvas, text, {format: "CODE39"});
            
            return canvas.toDataURL("image/png");
        }
    </script>
</div>
</p>


