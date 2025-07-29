<?php

$level_us = isset($_SESSION["level_user"]) ? $_SESSION["level_user"] : '';
$level3   = isset($_SESSION["login_user"]) ? $_SESSION["login_user"] : '';
$page     = isset($data['page']) ? $data['page'] : '';
$pages    = isset($data['pages']) ? $data['pages'] : '';
?>
<style>
    /* Default: sembunyikan sidebar di layar kecil */
    @media (max-width: 1199.98px) {
        .sidebar-wrapper {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            width: 250px;
            /* atau sesuai ukuran sidebar kamu */
            height: 100%;
            background-color: #fff;
        }

        .sidebar-wrapper.show-sidebar {
            transform: translateX(0);
        }
    }

    #app {
        display: flex;
    }

    .sidebar-wrapper {
        width: 250px;
        transition: all 0.3s ease;
    }

    .sidebar-wrapper.collapsed {
        width: 70px;
        /* sidebar versi kecil */
    }

    #main {
        flex: 1;
        transition: all 0.3s ease;
        padding: 20px;
    }

    /* kode baru */
    #app {
        display: flex;
    }

    .sidebar-wrapper {
        width: 250px;
        transition: all 0.3s ease;
    }

    .sidebar-wrapper.collapsed {
        width: 70px;
        /* sidebar versi kecil */
    }

    #main {
        flex: 1;
        transition: all 0.3s ease;
        padding: 20px;
    }

    @media (max-width: 1199.98px) {
        .sidebar-wrapper {
            position: fixed;
            z-index: 1000;
            transform: translateX(-100%);
            height: 100vh;
        }

        .sidebar-wrapper.show-sidebar {
            transform: translateX(0);
        }

        #main {
            margin-left: 0 !important;
        }
    }
</style>
<div id="app">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="logo">
                        <h5><a href="<?= base_url ?>/home"><?= $_SESSION['login_user'] ?></a></h5>
                    </div>
                    <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                        <div class="form-check form-switch fs-6"><input class="me-0" type="hidden" id="toggle-dark"></div>
                    </div>
                    <div class="sidebar-toggler x"><a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a></div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu">
                    <li class="sidebar-title">Master</li>
                    <li class="sidebar-item <?= $pages == 'home' ? 'active' : '' ?>"><a href="<?= base_url ?>/home" class="sidebar-link"><i class="bi bi-box-seam"></i><span>Dashboard</span></a></li>
                    <li class="sidebar-item <?= $pages == 'msfor' ? 'active' : '' ?>"><a href="<?= base_url ?>/msforwader" class="sidebar-link"><i class="bi bi-truck"></i><span>Master Forwader</span></a></li>
                    <li class="sidebar-title">Menu Belum Final</li>
                    <li class="sidebar-item <?= $pages == 'inputkrus' ? 'active' : '' ?>"><a href="<?= base_url ?>/transaksikurs" class="sidebar-link"><i class="bi bi-cash-stack"></i><span>Input Biaya Import</span></a></li>
                    <li class="sidebar-item <?= $pages == 'post' ? 'active' : '' ?>"><a href="<?= base_url ?>/transaksikurs/postlist" class="sidebar-link"><i class="bi bi-journal-check"></i><span>Posted</span></a></li>
                    <li class="sidebar-item <?= $pages == 'lap' ? 'active' : '' ?>"><a href="<?= base_url ?>/laporankurs/packing" class="sidebar-link"><i class="bi bi-file-earmark-bar-graph"></i><span>Laporan</span></a></li>
                    <li class="sidebar-title">Menu Final</li>
                    <li class="sidebar-item <?= $pages == 'inputkrusfinal' ? 'active' : '' ?>"><a href="<?= base_url ?>/transaksifinalkurs" class="sidebar-link"><i class="bi bi-pencil-square"></i><span>Input Final</span></a></li>
                    <li class="sidebar-item <?= $pages == 'listkrusfinal' ? 'active' : '' ?>"><a href="<?= base_url ?>/transaksifinalkurs/listfinal" class="sidebar-link"><i class="bi bi-list-task"></i><span>List Final</span></a></li>
                    <li class="sidebar-item <?= $pages == 'postfinal' ? 'active' : '' ?>"><a href="<?= base_url ?>/transaksifinalkurs/postlist" class="sidebar-link"><i class="bi bi-journal-check"></i><span>Posted Final</span></a></li>
                    <li class="sidebar-item <?= $pages == 'lapfinal' ? 'active' : '' ?>"><a href="<?= base_url ?>/laporankursfinal/packing" class="sidebar-link"><i class="bi bi-file-earmark-bar-graph"></i><span>Laporan Final</span></a></li>
                </ul>
                <ul class="menu">
                    <li class="sidebar-title mt-4">User</li>
                    <li class="sidebar-item"><a href="<?= base_url ?>/logout" class="sidebar-link text-danger"><i class="bi bi-box-arrow-right"></i><span>Sign Out</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const burgerBtn = document.querySelector('.burger-btn');
        const sidebar = document.querySelector('.sidebar-wrapper');
        const sidebarHideBtn = document.querySelector('.sidebar-hide');
        const logoutLink = document.querySelector('a[href*="/logout"]');
        const sidebarWrapper = document.querySelector('.sidebar-wrapper');
        const activeItem = sidebarWrapper?.querySelector('.sidebar-item.active');
        const cardElement = document.querySelector('.card');

        // Toggle tampilkan sidebar saat tombol burger diklik
        if (burgerBtn && sidebar) {
            burgerBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('show-sidebar');
            });
        }

        // Sembunyikan sidebar saat tombol close (X) diklik
        if (sidebarHideBtn && sidebar) {
            sidebarHideBtn.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.remove('show-sidebar');
            });
        }

        // Scroll otomatis ke menu aktif di sidebar
        if (activeItem) {
            const sidebarTop = sidebarWrapper.scrollTop;
            const itemTop = activeItem.offsetTop;
            const itemBottom = itemTop + activeItem.offsetHeight;
            const wrapperHeight = sidebarWrapper.clientHeight;

            if (itemBottom > sidebarTop + wrapperHeight) {
                sidebarWrapper.scrollTo({
                    top: itemTop - 60,
                    behavior: "smooth"
                });
            }

            if (itemTop < sidebarTop) {
                sidebarWrapper.scrollTo({
                    top: itemTop - 20,
                    behavior: "smooth"
                });
            }
        }

        // Sembunyikan scrollbar jika menu aktif atau card muncul
        if ((activeItem || cardElement) && sidebarWrapper) {
            sidebarWrapper.classList.add("hide-scrollbar");
        }

        // Konfirmasi logout
        if (logoutLink) {
            logoutLink.addEventListener("click", function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin logout?',
                    text: "Anda akan keluar dari aplikasi. Biaya Import ..",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = logoutLink.href;
                    }
                });
            });
        }


    });
</script>