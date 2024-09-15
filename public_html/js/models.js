import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go} from "./lib/listener_1.js";

console.log('Models js');

window.addEventListener('load', (event) => {
    
    log('The page has fully loaded');
    //loadDynamic('#Login', 'index.php?page=Login&action=in', 0);
    //loadDynamic('#User', 'index.php?page=User&action=index', 0);
    loadDynamic('#Menu', go('Index/menu'), 0);
    loadDynamic('#Models', go('Models/index'), 0);
    loadDynamic('#Fields', go('Fields/index'), 0);
    loadDynamic('#Generate', go('Generate/index'), 0);
    //addLoadAll();
    addDynamicElements(500);  
});

