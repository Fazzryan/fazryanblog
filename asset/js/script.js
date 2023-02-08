window.addEventListener("scroll", () => {
    const nav = document.querySelector(".nav-bar");
    if (window.pageYOffset > 0) {
        nav.classList.add("add-shadow");
    } else {
        nav.classList.remove("add-shadow");
    }
});

// var halaman = document.getElementById('page');
var halamanSekarang = document.getElementById('page-sekarang');

for (var i = 0; i < halamanSekarang.length; i++) {
    halamanSekarang[i].addEventListener("click", function () {
        var sekarang = document.getElementsByClassName("halaman-aktif");
        sekarang[0].className = sekarang[0].className.replace(" halaman-aktif", "");
        this.className += " halaman-aktif";
    });
}
