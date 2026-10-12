    <footer class="footer">

        <div class="ABOUTUS">
            <h3>ABOUT US</h3>
            <hr class="divider">
            <p>Together we can <br>make a bigger <br>impact.
                Help today,<br> build a better <br>tomorrow
            </p>
        </div>

        <div class="Finfo CONTACT">
            <h3>CONTACTS</h3>
            <hr class="divider">
            <p>time2help@gmail.com</p>
            <p>+091 - 234 - 567</p>

            <div class="social-icons">
                <a href="#"><img src="fb.webp" alt="Facebook"></a>
                <a href="#"><img src="ig.webp" alt="Instagram"></a>
                <a href="#"><img src="tiktok.webp" alt="TikTok"></a>
                <a href="#"><img src="yt.webp" alt="YouTube"></a>
            </div>
        </div>

        <div class="Finfo">
            <h3>SUPPORT</h3>
            <hr class="divider">
            <ul>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="guidelines.php">Safety Guidelines</a></li>
            </ul>
        </div>

        <div class="Finfo Flogo">
            <h3 class="F2logo">TIME2HELP</h3>
        </div>
        <div class="footer-line"></div>
    </footer>

    <script>
        const hamburger = document.querySelector(".hamburger");
        const sideMenu = document.querySelector(".side-menu");
        const overlay = document.querySelector(".menu-overlay");
        const closeMenu = document.querySelector(".close-menu");

        function openMenu() {
            sideMenu.classList.add("active");
            overlay.classList.add("active");
        }

        function hideMenu() {
            sideMenu.classList.remove("active");
            overlay.classList.remove("active");
        }

        if (hamburger && sideMenu && overlay && closeMenu) {
            hamburger.addEventListener("click", openMenu);
            closeMenu.addEventListener("click", hideMenu);
            overlay.addEventListener("click", hideMenu);
        }
    </script>
</body>

</html>
