import {loadDynamic, addLoadAll, addDynamicElements, log, setDebug, go} from "./lib/listener_1.js";

console.log('main js');

window.addEventListener('load', (event) => {
    
    log('The page has fully loaded');
    //loadDynamic('#Menu', 'index.php?page=Index&action=menu', 0);
    loadDynamic('#Menu', go('Index/menu'), 0);
    //'index.php?page=Book&action=index'
    loadDynamic('#Book', go('Book/index'), 0);
    //loadDynamic('#Author', 'index.php?page=Author&action=index', 0);
    loadDynamic('#Author', go('Author/index'), 0);
    //loadDynamic('#User', 'index.php?page=User&action=index', 0);
    loadDynamic('#User', go('User/index'), 0);
    //loadDynamic('#Rules', 'index.php?page=Rules&action=index', 0);
    loadDynamic('#Rules', go('Rules/index'), 0);
    //loadDynamic('#Test', 'index.php?page=Test&action=index', 0);
    loadDynamic('#Test', go('Test/index'), 0);
    //addLoadAll();
    addDynamicElements(500);  
});

function logg(mes) {
    console.log(mes);
}