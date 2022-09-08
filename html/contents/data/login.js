"use strict";
window.addEventListener("load",function(){
    (async()=>{
        const res=await (await fetch("?action=log_check",{method:"POST"})).json();
        res?on_login():"";
    })();
})
const body=document.querySelector("body");
const main=document.querySelector("main");
const header=document.querySelector("header");
const login=document.getElementById("login");
login.addEventListener("click",dialog_check);

 //dialogがすでにあった場合削除
function dialog_check(){
    //変数loginがlogoutに変わっていた場合、発火
    if(login.classList.contains("logout")){
        logout();
        return;
    }
    main.classList.toggle("operation_non");
    header.classList.toggle("operation_non");
    if(document.querySelector("dialog")){
        document.querySelector("dialog").remove();
        return;
    }
    dialog_create();
}

//dialogの作成・削除
function dialog_create(){   
    const dialog=document.createElement("dialog");
    const input=document.createElement("input");
    input.type="number";
    dialog.appendChild(input);
    body.appendChild(dialog);
    input_count(input);    
    dialog.show();
}
//pwの入力数が3になったら送信
function input_count(input){
    let pw="";
    input.addEventListener("keydown" , e =>{
        if(e.code === "Backspace"){
            pw=pw.replace(/.$/, '');
        }
        if(Number.isInteger(parseInt(e.code.substring(5,6)))){
            pw+=e.code.substring(5,6);
            if(pw.length === 3){
                a_login(pw , input);
                pw="";
            }
        }
    })
}

//pwがあってるかのチェック
async function a_login(pw , input){
    const data=new FormData();
    data.append("pw",pw);
    const res=await (await fetch("?action=login",{method:"POST",body:data})).json();
    if(res){
        dialog_check();
        on_login();
    }
    input.value="";
}

function on_login(){
    main.classList.toggle("login_on");
    header.classList.toggle("login_on");

    login.textContent="logout";
    login.classList.toggle("logout");
}

async function logout(){
    fetch("?action=logout",{method:"POST"});

    main.classList.toggle("login_on");
    header.classList.toggle("login_on");
    login.textContent="login";
    login.classList.toggle("logout");
}