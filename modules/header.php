<nav class="navbar navbar-expand-lg">
  <a class="navbar-brand" href="?p=newpage">Dynamic</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <?php
            foreach($menu as $link) {
                if($link->page_link !== 'newpage') {
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" href="?p='.$link->page_link.'"> '.$link->page_title.' </a>';
                    echo '</li>';
                }
            }
        ?>

    </ul>
  </div>
</nav>