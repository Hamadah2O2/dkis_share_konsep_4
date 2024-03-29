<?php
include '../../koneksi.php';
include '../../funcvar.php';
session_start();

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
  $nama = $_SESSION['nama'];
} else {
  header("location: ../login");
}

$sortby = $_POST['col'];
$asdesc = $_POST['asdesc'];

if (isset($_POST['search']) && $_POST['search'] != "") {
  $s = $_POST['search'];
  $s = strtolower($s);
  $stm = $c->query("SELECT * FROM files WHERE globaly = 1 AND (LOWER(nama) LIKE '%$s%' OR LOWER(jenis) LIKE '%$s%' OR LOWER(tag) LIKE '%$s%' OR LOWER(date) LIKE '%$s%') ORDER BY $sortby $asdesc");
} else {
  $stm = $c->query("SELECT * FROM files WHERE globaly = 1 ORDER BY $sortby $asdesc");
} ?>

<div class="d-none">
  <input type="text" name="asdesc" id="asdesc" value="<?= $asdesc ?>">
  <input type="text" name="sortby" id="sortby" value="<?= $sortby ?>">
</div>
<form method="post" id="dataFile">
  <thead>
    <tr>
      <th onclick="load_files('', 'nama', '<?= ($asdesc == 'ASC') ? 'DESC' : 'ASC'; ?>')">Nama File <i class="fas fa-sort<?= ($sortby == 'nama') ? ($asdesc == 'ASC') ? '-up' : '-down' : ' text-black-50' ; ?>"></i></th>
      <th onclick="load_files('', 'ukuran', '<?= ($asdesc == 'ASC') ? 'DESC' : 'ASC'; ?>')">Ukuran <i class="fas fa-sort<?= ($sortby == 'ukuran') ? ($asdesc == 'ASC') ? '-up' : '-down' : ' text-black-50' ; ?>"></i></th>
      <th onclick="load_files('', 'date', '<?= ($asdesc == 'ASC') ? 'DESC' : 'ASC'; ?>')">Date <i class="fas fa-sort<?= ($sortby == 'date') ? ($asdesc == 'ASC') ? '-up' : '-down' : ' text-black-50' ; ?>"></i></th>
      <th onclick="load_files('', 'tag', '<?= ($asdesc == 'ASC') ? 'DESC' : 'ASC'; ?>')" class="text-center">Tag <i class="fas fa-sort<?= ($sortby == 'tag') ? ($asdesc == 'ASC') ? '-up' : '-down' : ' text-black-50' ; ?>"></i></th>
      <th class="text-center">Aksi </th>
    </tr>
  </thead>
  <tbody>
    <?php
    while ($data = $stm->fetch_array()) { ?>
      <tr>
        <td>
          <?= $data['nama'] ?>
        </td>
        <td><?= size_format($data['ukuran']) ?></td>
        <td><?= $data['date'] ?></td>
        <td class="text-center"><?= ($data['tag'] == "") ? "----" : "$data[tag]" ?></td>
        <td class="text-center">
          <a href="./download?id=<?= $data[0] ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Download">
            <i class="fas fa-arrow-down" style="font-size: 15px;"></i>
          </a>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</form>