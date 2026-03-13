<section class="container mx-auto min-h-screen w-screen grid sm:grid-cols-2 lg:grid-cols-3 gap-5 py-10 justify-center items-center">
    <?php
        foreach($horses as $horse){
            ?>

            <div class="card">
            <header>
                <h2><?= $horse["nomMonture"] ?><span class="text-muted-foreground font-normal ml-2"><?= $horse["race"] ?></span></h2>
                <p><?= $horse["robe"] ?></p>
            </header>
            <section class="px-0">
                <img
                alt="Photo de <?= $horse["nomMonture"] ?>"
                loading="lazy"
                width="500"
                height="500"
                class="aspect-video object-cover" style="color:transparent"
                src="<?= $horse["photoMonture"] ?>"
                />
            </section>
            <footer class="flex items-center gap-2">
                <span class="badge-outline">
                <?php
                    if ($horse["sexe"] == "Femelle") {
                        echo '<svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6450)><path d="M12 16C15.866 16 19 12.866 19 9C19 5.13401 15.866 2 12 2C8.13401 2 5 5.13401 5 9C5 12.866 8.13401 16 12 16Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><g opacity=0.4><path d="M12 16V22"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M15 19H9"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></g><defs><clipPath id=clip0_4418_6450><rect fill=white height=24 width=24 /></clipPath></defs></svg>';
                    }else{
                        echo '<svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6449)><path d="M10.25 21.5C14.5302 21.5 18 18.0302 18 13.75C18 9.46979 14.5302 6 10.25 6C5.96979 6 2.5 9.46979 2.5 13.75C2.5 18.0302 5.96979 21.5 10.25 21.5Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><g opacity=0.4><path d="M21.5 2.5L16 8"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M15 2.5H21.5V9"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></g><defs><clipPath id=clip0_4418_6449><rect fill=white height=24 width=24 /></clipPath></defs></svg>';
                    }
                    echo $horse["sexe"];
                ?>
                </span>
                <span class="badge-outline">
                <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_6368)><path d="M10 22H14C19 22 21 20 21 15V9C21 4 19 2 14 2H10C5 2 3 4 3 9V15C3 20 5 22 10 22Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M17.25 8.28992C14.26 5.62992 9.74 5.62992 6.75 8.28992L8.93 11.7899C10.68 10.2299 13.32 10.2299 15.07 11.7899L17.25 8.28992Z"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 opacity=0.4 /></g><defs><clipPath id=clip0_4418_6368><rect fill=white height=24 width=24 /></clipPath></defs></svg>
                <?= $horse["poids"] ?> kg
                </span>
                <span class="badge-outline">
                <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_4418_5469)><path d="M3 22H21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M3 2H21"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><g opacity=0.4><path d="M12 6V18"stroke=currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M14.8299 7.71965L11.9999 4.88965L9.16992 7.71965"stroke=#currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /><path d="M14.8299 15.8896L11.9999 18.7196L9.16992 15.8896"stroke=#currentColor stroke-linecap=round stroke-linejoin=round stroke-width=1.5 /></g></g><defs><clipPath id=clip0_4418_5469><rect fill=currentColor height=24 width=24 /></clipPath></defs></svg>
                <?= $horse["taille"] ?> cm
                </span>
                <span class="badge-outline ml-auto">
                <svg fill=none height=24 viewBox="0 0 24 24"width=24 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_3261_13291)><path d="M7.2 7.76007C7.2 7.98007 7.01 8.17007 6.79 8.14007C6.57 8.14007 6.38 7.95007 6.38 7.73007C6.38 7.51007 6.57 7.32007 6.79 7.32007C6.99584 7.32007 7.2 7.51763 7.2 7.73007"stroke=currentColor stroke-width=1.5 stroke-linecap=round stroke-linejoin=round /><path d="M22.6899 13.79L21.6099 14.04C20.8399 14.22 20.2299 14.82 20.0499 15.6L19.7999 16.68C19.7799 16.79 19.6099 16.79 19.5799 16.68L19.3299 15.6C19.1499 14.83 18.5499 14.22 17.7699 14.04L16.6899 13.79C16.5799 13.77 16.5799 13.6 16.6899 13.57L17.7699 13.32C18.5399 13.14 19.1499 12.54 19.3299 11.76L19.5799 10.68C19.5999 10.57 19.7699 10.57 19.7999 10.68L20.0499 11.76C20.2299 12.53 20.8299 13.14 21.6099 13.32L22.6899 13.57C22.7999 13.59 22.7999 13.76 22.6899 13.79Z"stroke=currentColor stroke-width=1.5 stroke-miterlimit=10 /><path d="M17.56 18.86L15.46 20.96C14.29 22.13 12.39 22.13 11.22 20.96L2.09997 11.84C1.53997 11.28 1.21997 10.51 1.21997 9.72004V7.26004C1.21997 6.46004 1.53997 5.70004 2.09997 5.14004L4.16997 3.07004C4.72997 2.51004 5.47997 2.20004 6.26997 2.19004L8.95997 2.17004C9.76997 2.17004 10.55 2.49004 11.12 3.07004L17.27 9.33004"stroke=currentColor stroke-width=1.5 stroke-linecap=round stroke-linejoin=round opacity=0.4 /></g><defs><clipPath id=clip0_3261_13291><rect fill=currentColor height=24 width=24 /></clipPath></defs></svg>
                <?= empty($horse["numProprietaire"]) ? "Centre" : $horse["nomCavalier"] . " " . $horse["prenomCavalier"]?>
                </span>
            </footer>
            </div>

            <?php
        }
    ?>
</section>
