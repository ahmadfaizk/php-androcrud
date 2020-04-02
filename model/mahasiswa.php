<?php

function createMahasiswa($conn, $nama, $alamat) {
    $sql = "INSERT INTO profile(nama,alamat) VALUES('$nama','$alamat')";
    if (mysqli_query($conn, $sql)) {
        return true;
    }
    mysqli_close($conn);
    return false;
}

function getMahasiswa($conn) {
    $sql = "SELECT * FROM profile";
    $result = mysqli_query($conn, $sql);

    $mahasiswa = array();
    while ($row = mysqli_fetch_array($result)) {
        $mahasiswa_temp = array();
        $mahasiswa_temp['id'] = $row['id'];
        $mahasiswa_temp['nama'] = $row['nama'];
        $mahasiswa_temp['alamat'] = $row['alamat'];
        array_push($mahasiswa, $mahasiswa_temp);
    }
    mysqli_close($conn);
    return $mahasiswa;
}

function updateMahasiswa($conn, $id, $nama, $alamat) {
    $sql = "UPDATE profile SET nama='$nama', alamat='$alamat' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        return true;
    }
    mysqli_close($conn);
    return false;
}

function deleteMahasiswa($conn, $id) {
    $sql = "DELETE FROM profile WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        return true;
    }
    mysqli_close($conn);
    return false;
}
