function previewImg(idInput, previewImg) {
    const gambar = document.querySelector(idInput);
    // const gambarLabel = document.querySelector('.custom-file-label.gambar1');
    const imgPreview = document.querySelector(previewImg);

    // isikan nama pada label sesuai gambar
    // gambarLabel.textContent = gambar.files[0].name;

    // mengambil file yang akan di upload, lalu ambil nama filenya
    const fileGambar = new FileReader();
    fileGambar.readAsDataURL(gambar.files[0]);

    // untuk disimpan ke gambarnya
    // ketika di load
    fileGambar.onload = function (e) {
        // ubah preview
        imgPreview.src = e.target.result;
    };
}
