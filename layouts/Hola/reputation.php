<?php

defined('_EXEC') or die;

$this->dependencies->add(['css', '{$path.css}Hola/reputation.css']);

?>

<main class="landing-page-reputation">
    <section class="st-1">
        <div>
            <figure>
                <img src="{$path.images}hola/reputation/logotype-color.png" alt="Logotype">
            </figure>
            <h1>{$lang.st-1-text-1}</h1>
        </div>
        <figure>
            <img src="{$path.images}hola/reputation/st-1-img-1.png" alt="Logotype">
        </figure>
        <div>
            <p>{$lang.st-1-text-2}</p>
        </div>
    </section>
    <section class="st-2">
        <div>
            <div>
                <div>
                    <div>
                        <figure>
                            <img src="{$path.images}hola/reputation/st-2-img-1.png" alt="Asset">
                        </figure>
                        <div>
                            <p>{$lang.st-2-text-1}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <figure>
                            <img src="{$path.images}hola/reputation/st-2-img-2.png" alt="Asset">
                        </figure>
                        <div>
                            <p>{$lang.st-2-text-2}</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div>
                        <figure>
                            <img src="{$path.images}hola/reputation/st-2-img-3.png" alt="Asset">
                        </figure>
                        <div>
                            <p>{$lang.st-2-text-3}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <a>{$lang.st-2-text-4}</a>
        </div>
    </section>
    <section class="st-3">
        <div>
            <p>{$lang.st-3-text-1}</p>
        </div>
        <div>
            <div>
                <h2>{$lang.st-3-text-2}</h2>
                <p>{$lang.st-3-text-3}</p>
            </div>
            <figure>
                <img src="{$path.images}hola/reputation/st-3-img-1.png" alt="Asset">
            </figure>
        </div>
    </section>
</main>
