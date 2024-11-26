<div class="Menu" id="Menu"></div>
<div class="<?= $model; ?>" id="<?= $model;?>"></div>

<div class="Fields" id="Fields"></div>
<div class="Generate" id="Generate"></div>
<div class="Result" id="Result"></div>

<dialog id="myDialog" aria-labelledby="dialog-name"></dialog>

<script type="module">

    import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go} from "./js/lib/listener_1.js";
    
    console.log('<?php echo $model;?> js');
    
    window.addEventListener('load', (event) => {
        log('The page has fully loaded');
        loadDynamic('#Menu', go('Index/menu'), 0);
        loadDynamic('#<?php echo $model;?>', go('<?php echo $model;?>/index'), 0);
        
        //loadDynamic('#Fields', go('Fields/index'), 0);
        //loadDynamic('#Generate', go('Generate/index'), 0);        
        //addLoadAll();
        addDynamicElements(100);  
    });
</script>
