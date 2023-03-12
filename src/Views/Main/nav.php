<nav id="mainNav">
    <div id="nav-wrraper">
        <div id="logo"> 
            <a href="/">
                <img src="<?php echo $this->assets('img/logo.png'); ?>" alt="Buster Logo" width="148px" height="148px"> 
            </a>            
        </div>

        <div class="nav-item">
            <a href="/movies">Movies</a>
        </div>

        <div class="nav-item">
            <a href="/categories">Categories</a>
        </div>

        <div class="nav-item">
            <a href="/mostrented">Most Rented</a>
        </div>
        
        <div id="search-bar-nav-wraper">
            <form method="POST" action="/api/movies"> 
                <input name="m_name" type="text" placeholder="Search...."/><button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>    
</nav>