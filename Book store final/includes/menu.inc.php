<nav class="navbar">
    <div class="logo">
        <div></div>
        <img src="img/logo2.jpg" alt="" style="width: 40px; height: 30px;">
        <h2>Book Bay</h2>
    </div>

    <div class="navmenu">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#blog">Blog</a></li>
            <li><a href="backend/books.php">Books</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contactus">Contact </a> </li>
        </ul>
        <form method="GET" action="search_result.php">
            <fieldset>
                <input type="text" id="s" name="s" value="" />
                <input type="submit" id="x" value="Search" />
            </fieldset>
        </form>
        <!-- <div class="search-box">
            <input type="search" class="search" placeholder="search here....">
            <i class='bx bx-search' onclick="search()"></i>
            </div> -->
    </div>

    <div class="menuicon">
        <button onclick="myFunction()" class="icon">
            <i class="fa fa-bars"></i>
        </button>

    </div>