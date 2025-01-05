<div class="Menu" id="Menu"></div>
<div class="<?= $model; ?>" id="<?= $model;?>"></div>
<div class="UserStatus" id="UserStatus"></div>

<dialog id="myDialog" aria-labelledby="dialog-name"></dialog>

<script type="module">

    import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go, goParams} from "./js/lib/listener_1.js";
    
    console.log('<?php echo $model;?> js --> Debug');
    
    window.addEventListener('load', (event) => {
        log('The page has fully loaded');
        //loadDynamic('#User', go('User/index'), 0);
        loadDynamic('#Menu', go('Index/menu'), 0);
        loadDynamic('#<?php echo $model;?>', goParams('<?php echo $model;?>/index'), 0);
        loadDynamic('#UserStatus', go('UserStatus/index'), 0);
        //addLoadAll();
        addDynamicElements(100);  
    });
</script>

