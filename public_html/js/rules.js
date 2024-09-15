import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go} from "./lib/listener_1.js";

console.log('User js');

window.addEventListener('load', (event) => {
    
    log('The page has fully loaded');
    //loadDynamic('#Login', 'index.php?page=Login&action=in', 0);
    //loadDynamic('#User', 'index.php?page=User&action=index', 0);
    loadDynamic('#Rules', go('Rules/index'), 0);
    //addLoadAll();
    addDynamicElements(500);  
});

