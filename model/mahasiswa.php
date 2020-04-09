<?php

function createMahasiswa($conn, $nama, $alamat, $foto) {
    $sql = "INSERT INTO profile(nama, alamat, foto) VALUES('$nama','$alamat', '$foto')";
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
        $mahasiswa_temp['foto'] = $row['foto'];
        array_push($mahasiswa, $mahasiswa_temp);
    }
    mysqli_close($conn);
    return $mahasiswa;
}

function updateMahasiswaAndUploadImage($conn, $id, $nama, $alamat, $foto) {
    $sql = "UPDATE profile SET nama='$nama', alamat='$alamat', foto='$foto' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        return true;
    }
    mysqli_close($conn);
    return false;
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
