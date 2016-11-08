<style type="text/css">
td, th {
    border: 1px solid black;
}

table {
    border-collapse: collapse;
}
</style>

<h1>View of SomeController inside SomeModule</h1>

<table style="width: 100%; border: 1px solid black">
    <thead>
        <tr>
        	<th>No</th>
        	<th>Nama</th>
        	<th>Kelamin</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($table as $key => $row) : ?>
        <tr>
        	<td><?php echo $key; ?></td>
        	<td><?php echo $row['nama']; ?></td>
        	<td><?php echo $row['kelamin']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>