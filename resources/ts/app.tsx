import '../scss/app.scss';
import M from 'materialize-css';
import {render} from 'react-dom';
import React from "react";
import App from './components/App';


document.addEventListener('DOMContentLoaded', () => {
    const reactApp = document.querySelector('#react-app');

    if (reactApp) {
        render(<App/>, reactApp);
    }

    M.AutoInit();
});