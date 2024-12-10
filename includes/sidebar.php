<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="/" class="logo-wrapper" title="Home">
                <span class="sr-only">Home</span>
                <span class="mx-2" aria-hidden="true"><img src="img/logos/<?php echo $logo; ?>"
                        style="width: 80px;height: 80px"></img></span>
                <div class="logo-text">
                    <span class="logo-title">BIMS</span>
                    <!--span class="logo-subtitle">Dashboard</span-->
                </div>

            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                <li>
                    <a id="dashboard_btn" href="index.php"><span class="icon home"
                            aria-hidden="true"></span>Dashboard</a>
                </li>
                <?php
                if($dept === "Admin" || $dept === "Secretariant" || $dept === "Clearance"){echo'
                    <li>
                        <a id="certificates_btn" href="certificates.php">
                            <span class="icon document" aria-hidden="true"></span>Certificates
                        </a>
                        <button class="category__btn transparent-btn show-cat-btn" title="Open list">
                            <span class="sr-only">Open list</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </button>
                        <ul class="cat-sub-menu">';
        
                            if($dept === "Admin" || $dept === "Secretariant"){
                                echo '
                                <li>
                                    <a href="create-certificate-of-residency.php">Residency</a>
                                </li>
                                <li>
                                    <a href="create-certificate-of-indigency.php">Indigency</a>
                                </li>
                                <li>
                                    <a href="create-certificate-of-good-moral.php">Good Moral</a>
                                </li>
                                <li>
                                    <a href="create-certificate-of-FTJS.php">First-Time-Job-Seeker</a>
                                </li>';
                            }

                            if($dept === "Admin" || $dept === "Clearance"){
                                echo'
                                <li>
                                    <a href="create-business-permits.php">Business Permits</a>
                                </li>
                                <li>
                                    <a href="create-building-permits.php">Building Permits</a>
                                </li>
                                <li>
                                    <a href="create-excavation-permits.php">Excavation Permits</a>
                                </li>
                                <li>
                                    <a href="create-fencing-permits.php">Fencing Permits</a>
                                </li>
                                <li>
                                    <a href="create-tprs.php">TPRS</a>
                                </li>';
                            }

                            
                        echo '</ul>
                    </li>';
                }?>

                <li>
                    <a id="resident_btn" href="residents.php"><span class="icon home"
                            aria-hidden="true"></span>Residents</a>

                </li>
                <li>
                    <a id="non_resident_btn" href="nonresidents.php"><span class="icon user-3"
                            aria-hidden="true"></span>Non-Residents</a>

                </li>
                <?php
                    if($dept === "Lupon" || $dept === "Admin"){
                        echo '
                        <li>
                            <a id="blotter_btn" href="blotters.php"><span class="icon edit"
                                    aria-hidden="true"></span>Blotters</a>

                        </li>';
                    }
                
                ?>
                
            </ul>
            <?php 
                if($departmentno == 4 || $departmentno == 5 ){
                    echo '<span class="system-menu__title">system</span>
                    <ul class="sidebar-body-menu">
                        
                        </li>
                        
                        <li>
                                <a id="settings_btn" href="settings.php"><span class="icon setting" aria-hidden="true"></span>Settings</a>
                            </li>
                        
                    
                    </ul>';
                }
            ?>
        </div>
    </div>
    <div class="sidebar-footer">
        <a href="##" class="sidebar-user">
            <span class="sidebar-user-img">
                <picture>
                    <img src="<?php echo 'includes/img/users_img/'.$_SESSION["profile_pic"]?>" alt="User name">
                </picture>
            </span>
            <div class="sidebar-user-info text-center">
                <span class="sidebar-user__title"><?php echo $_SESSION['username']?></span>
                <span class="sidebar-user__subtitle"><?php echo $dept?></span>
            </div>
        </a>
    </div>
</aside>