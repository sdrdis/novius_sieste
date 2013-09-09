<?php
$nb_rows = 4;
$nb_cols = 4;
?>
<form action="save_data.php" method="GET">
    <table>
<?php
for ($row = 0; $row < $nb_rows; $row++) {
    echo '<tr>';
    for ($col = 0; $col < $nb_cols; $col++) {
        echo '<td>';
        echo '<input name="v[]" type="number" value="20" />';
        echo '</td>';
    }
    echo '</tr>';
}
?>
    </table>
    <input type="submit" />
</form>