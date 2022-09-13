"use strict";
const ul=document.querySelector("ul");
const main=document.querySelector("main");
let menu=(() =>{
    const data=[];
    const menu_list=document.querySelectorAll(".menu");
    menu_list.forEach(li =>{
        data.push(li.textContent);
    })
    data.push("dt");
    return data;
})();

//insert処理
const insert_count=document.querySelector("button");
insert_count.addEventListener("click", insert);

async function insert(){
    const data=new FormData();
    const menu=document.querySelectorAll(".menu");
    if(menu.length <= 2){
        alert("menuを追加してください");
        return;
    }
    menu.forEach(v =>{
        const count=v.parentNode.children[1].children[0].value;
        if(count === ""){
            alert("数値を入力してください");
            return;
        }
        data.append(v.textContent,count);
    })
    const res=await (await fetch("?action=register_count",{method:"POST",body:data})).json();
    console.log(res);
}

//delete処理
ul.addEventListener("click" , e => e.target.classList.contains("menu")?del(e.target):"");

const del=(async(target) =>{
    if(!confirm("削除しますか？"))return;
    const data=new FormData();
    data.append("column",target.textContent)
    const res= await (await fetch("?action=delete",{method:"POST",body:data})).json();
    const search=menu.filter(v => (v !== target.textContent));
    menu=search;
    res?target.parentNode.remove():alert("削除できませんでした");
})
//menuの登録
const register=document.getElementById("new");
register.addEventListener("click", register_form_create);
function register_form_create(){
    if(register.childElementCount >= 1){
        register.children[0].remove();
        return;
    }
    if(ul.childElementCount === 6){
        alert("menuが多すぎます");
        return;
    }
    const form=document.createElement("form");
    const input=document.createElement("input");
    input.type="text";
    input.maxLength=10;
    input.minLength=1;
    input.pattern="[a-z]{1,10}";
    form.appendChild(input);
    register.appendChild(form);
    input.focus();

    form.addEventListener("submit", register_send , this);
}

async function register_send(e){
    e.preventDefault();
    const val=document.querySelector("input[type='text']");
    if(val.value === "")return;
    const data=new FormData();
    data.append("val",val.value);
    const res=await fetch("?action=menu_register",{method:"POST",body:data});
    res?create_menu(val.value):alert("error");
    val.parentNode.remove();
}

function create_menu(menu_name){
    const ul=document.querySelector("ul");
    const li=document.createElement("li");
    const menu_span=document.createElement("span");
    menu_span.textContent=menu_name;
    menu_span.classList.add("menu");
    const span=document.createElement("span");
    const counter=document.createElement("input");
    counter.type="number";

    span.appendChild(counter);
    
    li.appendChild(menu_span);
    li.appendChild(span);

    ul.insertBefore(li,ul.firstChild);
    menu.unshift(menu_name);
}

