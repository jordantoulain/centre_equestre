<ol class="hidden sm:flex text-muted-foreground flex-wrap items-center gap-2.5 text-sm wrap-break-words ml-7">
  <li class="inline-flex items-center gap-1.5">
    <a href="./?p=home" class="hover:text-foreground transition-colors">Accueil</a>
  </li>
  <?php
  if ($action !== "home") {
    foreach($breadcrumbs as $breadcrumb) {
        echo '<li>
                <svg xmlns=http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-3.5"><path d="m9 18 6-6-6-6" /></svg>
            </li>';
        echo '<li class="inline-flex items-center gap-1.5">
                    <span class="hover:text-foreground transition-colors">' . $breadcrumb . '</span>
                </li>';
        }
    }

  ?>
</ol>
