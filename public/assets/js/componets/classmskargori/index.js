// index.js
import Modaltambah from './modaltambah.js';
import TampilListdata from './tampildata.js';

$(document).ready(function () {
   
const url = new URL(window.location.href);
const pathSegments = url.pathname.split("/");
const lastSegment = pathSegments.filter(Boolean).pop(); // filter untuk hilangkan elemen kosong
// Kondisi berdasarkan segmen terakhir URL


 new Modaltambah('#app');
 new TampilListdata();

  
});





