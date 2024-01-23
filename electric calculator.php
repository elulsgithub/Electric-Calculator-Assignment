<?php
function calculateElectricityCharge($voltage, $current, $rate) {
    // Calculate power in Watt-hours
    $power = $voltage * $current;

    // Calculate energy in kilowatt-hours
    $hours = 24;
    $energy = ($power * $hours) / 1000;
    // Calculate total charge

    $totalCharge = $energy * ($rate / 100);

    return [
        'power' => $power,
        'energy' => $energy,
        'totalCharge' => $totalCharge
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input
    $voltage = isset($_POST['voltage']) ? floatval($_POST['voltage']) : 0;
    $current = isset($_POST['current']) ? floatval($_POST['current']) : 0;
    $rate = isset($_POST['rate']) ? floatval($_POST['rate']) : 0;

    // Calculate electricity charge
    $result = calculateElectricityCharge($voltage, $current, $rate);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Electricity Calculator</title>
</head>
<body>

<div class="container mt-5">
    <h2>Electricity Calculator</h2>

    <form method="post">
        <div class="form-group">
            <label for="voltage">Voltage (V):</label>
            <input type="number" step="any" class="form-control" id="voltage" name="voltage" required>
        </div>

        <div class="form-group">
            <label for="current">Current (A):</label>
            <input type="number" step="any" class="form-control" id="current" name="current" required>
        </div>

        <div class="form-group">
            <label for="rate">Current Rate:</label>
            <input type="number" step="any" class="form-control" id="rate" name="rate" required>
        </div>

        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($result)): ?>
        <div class="mt-4">
            <h4>Results:</h4>
            <p>Power: <?= $result['power'] ?> Watt-hours</p>
            <p>Energy: <?= $result['energy'] ?> kWh</p>
            <p>Total Charge: $<?= number_format($result['totalCharge'], 2) ?></p>
            <p>Rate: RM <?= $_POST['rate']/100?><p>
        </div>

        <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Hour</th>
            <th scope="col">Energy (kWh)</th>
            <th scope="col">Total(RM)</th>
            </tr>
        </thead>
        <?php
            for( $i=1;$i<=24;$i++)
            {
        ?>
            <tr>
                <th scope="row"><?=$i?></th>
                <td><?=$i?></td>
                <?php 
                $voltage = $_POST['voltage'];
                $current = $_POST['current'];
                $rate = $_POST['rate'];
                $power = $voltage * $current;
                $energy = ($power * $i) / 1000;
                $total = $energy * ($rate / 100);
                ?>
                <td><?=$energy?></td>
                <td><?=number_format((float)$total, 2, '.', '')?></td>
            </tr>
        <?php
            }
        ?>
        <tbody>
            
        </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
