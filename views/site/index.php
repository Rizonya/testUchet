<?php
// views/site/index.php
$jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);
?>

<style>
    .topic { cursor:pointer; padding:5px; }
    .sub { cursor:pointer; padding:5px; }
    .selected { background: yellow; font-weight:bold; }
</style>

<table border="1" style="width:100%;">
    <tr>
        <th>Тема</th>
        <th>Подтема</th>
        <th>Текст</th>
    </tr>
    <tr>
        <td id="topics"></td>
        <td id="subtopics"></td>
        <td id="content"></td>
    </tr>
</table>

<script>
const data = <?= $jsonData ?>;

let currentTopic = 0;
let currentSub = 0;

const topicsEl = document.getElementById('topics');
const subtopicsEl = document.getElementById('subtopics');
const contentEl = document.getElementById('content');

function render() {
    // Темы
    topicsEl.innerHTML = data.map((t,i)=>`
        <div class="topic ${i===currentTopic?'selected':''}" data-i="${i}">${t.name}</div>
    `).join('');

    // Подтемы
    subtopicsEl.innerHTML = data[currentTopic].subtopics.map((s,i)=>`
        <div class="sub ${i===currentSub?'selected':''}" data-i="${i}">${s.name}</div>
    `).join('');

    // Контент
    contentEl.textContent = data[currentTopic].subtopics[currentSub].text;
}

topicsEl.addEventListener('click', e => {
    if(!e.target.dataset.i) return;
    currentTopic = +e.target.dataset.i;
    currentSub = 0; // выбрать первую подтему
    render();
});

subtopicsEl.addEventListener('click', e => {
    if(!e.target.dataset.i) return;
    currentSub = +e.target.dataset.i;
    render();
});


render();
</script>
