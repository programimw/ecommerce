<?php
error_reporting(0);

$host = "localhost";
$username = "root";
$password = "";
$database = "test_paga";

$conn = mysqli_connect($host,$username,$password, $database );

if (!$conn){
    echo "Error ne lidhjen me DB: ".mysqli_connect_error();
}

function printData($a)
{
    echo "<pre>";
    print_r($a);
    echo "</pre>";
}

// check if a date is weekend
function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
}
// marrim ditet e pushimit

$query_off_days = "SELECT date 
                   FROM off_days 
                   ORDER BY date ASC";

$result_off_days = mysqli_query($conn, $query_off_days);

if (!$result_off_days){
    echo "Error ".mysqli_error($conn);
    exit;
}

$off_days = array();
while ($row = mysqli_fetch_assoc($result_off_days)){
    $off_days[$row['date']] = $row['date'];
}


// Marrim punonjesit, daten e punes dhe oret e punes.


$query_users = "SELECT users.id, date, hours, full_name, total_paga
                FROM working_days
                         left join users on working_days.user_id = users.id;
                ";

$result_users = mysqli_query($conn, $query_users);
if (!$result_users){
    echo "Error ".mysqli_error($conn);
    exit;
}

$data_users = array();
while ($row = mysqli_fetch_assoc($result_users)){
    $data_users[$row['id']]['id'] = $row['id'];
    $data_users[$row['id']]['full_name'] = $row['full_name'];
    $data_users[$row['id']]['total_paga'] = $row['total_paga'];
    $hourly_payment = $row['total_paga']/22/8;
    $data_users[$row['id']]['hourly_payment'] = round($hourly_payment,2);

    $hours_in = $row['hours'];
    $hours_out = 0;

    if ($hours_in > 8){
        $hours_out = $hours_in - 8;
        $hours_in = 8;
    }

    $data_users[$row['id']]['hours_in'] += $hours_in;
    $data_users[$row['id']]['hours_out'] += $hours_out;
    $data_users[$row['id']]['total_hours'] += $hours_in + $hours_out;


    // kontrollojme datat dhe bejme llogaritje per cdo date
    if (isset($off_days[$row['date']])){
        $k_in = 1.5;
        $k_out = 2;
    } else if (isWeekend($row['date'])){
        $k_in = 1.25;
        $k_out = 1.5;
    } else {
        $k_in = 1;
        $k_out = 1.25;
    }

    $data_users[$row['id']]['paga_in'] += round ($hourly_payment * $hours_in * $k_in,2);
    $data_users[$row['id']]['paga_out'] += round ($hourly_payment * $hours_out * $k_out,2);
    $data_users[$row['id']]['total_paga'] += round ($hourly_payment * $hours_in * $k_in  + $hourly_payment * $hours_out * $k_out,2);

    // Llogaritjet per cdo date
    $data_users[$row['id']]['date'][$row['date']]['date'] = $row['date'];
    $data_users[$row['id']]['date'][$row['date']]['hours_in'] += $hours_in;
    $data_users[$row['id']]['date'][$row['date']]['hours_out'] += $hours_out;
    $data_users[$row['id']]['date'][$row['date']]['total_hours'] += $hours_in + $hours_out;
    $data_users[$row['id']]['date'][$row['date']]['paga_in'] += round ($hourly_payment * $hours_in * $k_in,2);
    $data_users[$row['id']]['date'][$row['date']]['paga_out'] += round ($hourly_payment * $hours_out * $k_out,2);
    $data_users[$row['id']]['date'][$row['date']]['total_paga'] += round ($hourly_payment * $hours_in * $k_in  + $hourly_payment * $hours_out * $k_out,2);

}

?>


<html>
<head>
    <style>
        .border-tabe {
            border: 1px solid black;
            width: 106px;
            text-align: center;
        }
        .hide {
            display: none;
        }
        .pointer-span{
            cursor: pointer;
            font-size: 30px;
        }
    </style>


</head>

<body>
<table>
    <tbody>
    <?php foreach ($data_users as $id => $data) { ?>
    <tr>
        <td class="border-tabe" onclick="toogle('<?=$id?>')"><span class = "pointer-span" id = "span_<?=$id?>" onclick="toogle('<?=$id?>')">+</span></td>
        <td class="border-tabe"><?=$data['full_name']?></td>
        <td class="border-tabe"><?=$data['hours_in']?></td>
        <td class="border-tabe"><?=$data['hours_out']?></td>
        <td class="border-tabe"><?=$data['total_hours']?></td>
        <td class="border-tabe"><?=$data['paga_in']?></td>
        <td class="border-tabe"><?=$data['paga_out']?></td>
        <td class="border-tabe"><?=$data['total_paga']?></td>
    </tr>
        <?php foreach ($data['date'] as $date => $details) { ?>
            <tr class="hide row_<?=$id?>">
                <td class="border-tabe"> </td>
                <td class="border-tabe"><?=$date?></td>
                <td class="border-tabe"><?=$details['hours_in']?></td>
                <td class="border-tabe"><?=$details['hours_out']?></td>
                <td class="border-tabe"><?=$details['total_hours']?></td>
                <td class="border-tabe"><?=$details['paga_in']?></td>
                <td class="border-tabe"><?=$details['paga_out']?></td>
                <td class="border-tabe"><?=$details['total_paga']?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
    <thead>
        <tr >
            <th class="border-tabe">Action</th>
            <th class="border-tabe">Full Name</th>
            <th class="border-tabe">Hours In</th>
            <th class="border-tabe">Hours Out</th>
            <th class="border-tabe">Total Hours</th>
            <th class="border-tabe">Payment In</th>
            <th class="border-tabe">Payment Out</th>
            <th class="border-tabe">Total Payment</th>
        </tr>
    </thead>
</table>
</body>
</html>


<script>
    function toogle(id){
        var type = document.getElementById("span_"+id).textContent;
        if (type == "+"){
            document.getElementById("span_"+id).textContent = "-";
            var rows = document.getElementsByClassName("row_"+id);
            console.log(rows)

            for (row of rows) {
                row.classList.remove("hide");
            }
        } else {
            document.getElementById("span_"+id).textContent = "+";
            var rows = document.getElementsByClassName("row_"+id);
            for (row of rows) {
                row.classList.add("hide");
            }
        }


    }
    //
    // element.;
</script>




