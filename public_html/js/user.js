import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go} from "./lib/listener_1.js";

console.log('User js');

window.addEventListener('load', (event) => {
    
    log('The page has fully loaded');
    //loadDynamic('#Login', 'index.php?page=Login&action=in', 0);
    loadDynamic('#User', go('User/index'), 0);
    loadDynamic('#UserStatus', go('UserStatus/index'), 0);
    //addLoadAll();
    addDynamicElements(500);  
});

