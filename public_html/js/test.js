import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go} from "./lib/listener_1.js";

console.log('Test js');

window.addEventListener('load', (event) => {
    
    log('The page has fully loaded');
    loadDynamic('#Menu', go('Index/menu'), 0);
    loadDynamic('#Test', go('Test/index'), 0);
    //addLoadAll();
    addDynamicElements(500);  
});

