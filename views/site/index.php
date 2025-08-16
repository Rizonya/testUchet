<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $deals array */
/* @var $contacts array */
?>

<div id="menu-table" style="width:100%; display:flex; gap:20px;">

    <div style="flex:1">
        <h3>Меню</h3>
        <ul id="menu">
            <li data-type="deals" class="selected">Сделки</li>
            <li data-type="contacts">Контакты</li>
        </ul>
    </div>

    <div style="flex:1">
        <h3>Список</h3>
        <ul id="list"></ul>
    </div>

    <div style="flex:2">
        <h3>Содержимое</h3>
        <div id="content"></div>
    </div>

</div>
<h3>Действия:</h3>
<button onclick="add()" id="addButton"></button>
<button onclick="update()">Изменить</button>
<button onclick="Delete()">Удалить</button>

<script>
const deals = <?= json_encode($deals) ?>;
const contacts = <?= json_encode($contacts) ?>;

let currentMenu = 'deals';
let currentItem = null;

function renderMenu() {
    document.querySelectorAll('#menu li').forEach(li=>{
        li.classList.remove('selected');
        if(li.dataset.type===currentMenu) li.classList.add('selected');

        addButton = document.getElementById('addButton')
        addButton.textContent = currentMenu==='deals'?'Добавить сделку':'Добавить контакт'
    });
    renderList();
}
function add(){

    window.location.href = '/'+currentMenu+'/update'
}
function update(){
    base = '/'+currentMenu+'/update'
    id = currentItem;
    console.log(base+'?id='+id)
    window.location.href = base+'?id='+id;

}

function Delete(){
    base = '/'+currentMenu+'/delete'
    id = currentItem;
    console.log(base+'?id='+id)
    window.location.href = base+'?id='+id;
}
function renderList() {
    const listEl = document.getElementById('list');
    listEl.innerHTML = '';
    let items = currentMenu==='deals'? deals : contacts;

    items.forEach(item=>{
        const li = document.createElement('li');
        li.textContent = item.label;
        li.dataset.id = item.id;
        li.onclick = ()=>{
            currentItem = item.id;
            renderContent();
            renderListSelection();
        }
        listEl.appendChild(li);
    });

    // Выбираем первый элемент по умолчанию
    if(items.length>0 && !currentItem) {
        currentItem = items[0].id;
        renderContent();
        renderListSelection();
    }
}

function renderListSelection() {
    document.querySelectorAll('#list li').forEach(li=>{
        li.style.background = (li.dataset.id==currentItem)? 'yellow' : '';
    });
}
function addRow(table,field, value) {
    const row = table.insertRow();
    row.insertCell().textContent = field;
    row.insertCell().textContent = value;
}
function renderContent() {
    const contentEl = document.getElementById('content');
    let item = (currentMenu==='deals'? deals : contacts).find(x=>x.id==currentItem);
    contentEl.innerHTML = '';

    if(!item) return;

    if(currentMenu==='deals') {
        const table = document.createElement('table');
        table.border = 1;
        table.style.width = '100%';


        addRow(table, 'id сделки', item.id);
        addRow(table, 'Наименование', item.label);
        addRow(table, 'Сумма', item.amount);
        addRow(table, 'Контакты:','')
        item.contacts.forEach((item)=>{
            addRow(table, 'ID контакта: '+item.id , 'ФИО: '+item.label)

        })

        contentEl.appendChild(table);


    } else {
        console.log('Я тут')
        const table = document.createElement('table');
        table.border = 1;
        table.style.width = '100%';


        addRow(table, 'id контакта',item.id)
        addRow(table, 'ФИО',item.label)
        addRow(table, 'Сделки:','')
        item.deals.forEach(item=>{
            addRow(table, 'id сделки: '+item.id,'Название: '+item.label)
        })

        contentEl.appendChild(table);
    }}

document.querySelectorAll('#menu li').forEach(li=>{
    li.onclick = ()=>{
        currentMenu = li.dataset.type;
        currentItem = null;
        renderMenu();
    }
});

renderMenu();
</script>

<style>
#menu li, #list li {
    cursor:pointer;
    padding:5px;
    list-style:none;
}
#menu li.selected {
    background: yellow;
}
#list li:hover {
    background:#eee;
}
</style>
