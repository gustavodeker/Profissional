<?php
function machineOption()
{   
    global $user;
    $user = auth($_SESSION['TOKEN']);
    global $pdo;
    if($user['user_level'] == 'admin'){
        $sql = $pdo->prepare("SELECT * FROM machines");
    } else{
        $sql = $pdo->prepare("SELECT * FROM machines WHERE machine_users LIKE '%,".$user['user_name'].",%'");
    }
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='". $row['machine_name']."'>". $row['machine_name']."</option>";
    }
}
function celulaOption()
{   
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM users");
    $sql->execute();
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='". $row['user_name']."'>". $row['user_name']."</option>";
    }
}
 
function codTable() //exibe a tabela
{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM codes");
    $sql->execute();
    $i = 1;
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        $ide = 'td' . $i;
        ?>
        <td class="tdcod" id='<?php echo $ide ?>' onclick="list('<?php echo $ide ?>')"><?php echo $row['code_code'] ?></td>
        <td class="tddesc" id='<?php echo $ide ?>' onclick="list('<?php echo $ide ?>')"><?php echo $row['code_desc'] ?></td>
        <?php
        $i++;
    }
}

function itemTable() //exibe a tabela
{
    global $pdo;
    $sql = $pdo->prepare("SELECT * FROM itens");
    $sql->execute();
    $u = 1000;
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        $ide2 = 'td' . $u;
        ?>
        <td class="tdcod" id='<?php echo $ide2 ?>' onclick="list2('<?php echo $ide2 ?>')"><?php echo $row['item_pn'] ?></td>
        <td class="tddesc" id='<?php echo $ide2 ?>' onclick="list2('<?php echo $ide2 ?>')"><?php echo $row['item_pn_desc'] ?></td>
        <?php
        $u++;
    }
}

?>
