import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go} from "./lib/listener_1.js";

console.log('Login js');

window.addEventListener('load', (event) => {
    
    log('The page has fully loaded');
    loadDynamic('#Login', go('Login/in'), 0);
    //addLoadAll();
    addDynamicElements(500);  
});

