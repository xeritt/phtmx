<div class="Flash" id="Flash"></div>
<div class="Menu" id="Menu"></div>
<div class="<?= $model; ?>" id="<?= $model;?>"></div>

<dialog id="myDialog" aria-labelledby="dialog-name"></dialog>

<script type="module">

    import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go, goParams} from "./js/lib/listener_1.js";
    
    console.log('<?php echo $model;?> js --> Debug');
    
    window.addEventListener('load', (event) => {
        log('The page has fully loaded');
        loadDynamic('#Menu', go('Index/menu'), 0);
        loadDynamic('#<?php echo $model;?>', goParams('<?php echo $model;?>/index'), 0);
        //addLoadAll();
        addDynamicElements(100);  
    });
</script>

