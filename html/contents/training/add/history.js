const history=document.getElementById("history");
history.addEventListener("click", history_page_create);

//historyのcreate
async function history_page_create(){
    ul.classList.toggle("disNone");
    if(document.getElementById("return")){
        this.textContent="history";
        this.id="history";
        document.querySelector("table").remove();
        return;
    }
    const res=await (await fetch("?action=history",{method:"POST"})).json();
    const table=(() =>{
        const table=document.createElement("table");
        const tr=document.createElement("tr");
        menu.forEach( v =>{
            const th=document.createElement("th");
            th.textContent=v;
            tr.appendChild(th);
        })
        table.appendChild(tr);
        return table;
    })();
    res.forEach(val =>{
        const tr=document.createElement("tr");
        tr.dataset.id=val.id;
        menu.forEach(m =>{
            if(m === "dt"){
                val[m]=val[m].slice(3).slice(0,13); 
            }
            const td=document.createElement("td");
            td.classList.add(m);
            td.textContent=val[m];
            tr.appendChild(td);
        })
        table.appendChild(tr);
    })
    this.id="return";
    this.textContent="return";
    main.appendChild(table);
    max_search();

    table.addEventListener("click", e => {
        e.target.tagName === "TD"?tr_delete(e.target.parentNode):"";
    });
}
//max値の検索
function max_search(){
    for(let v of menu){
        if(v === "dt")break;
        const target=document.querySelectorAll("."+v);

        let list=[];
        for(let v of target){
            const val=parseInt(v.textContent);
            list.push(val);
        }
        //自信と自信を比較することでNaNを判定できる
        list=list.filter( li => li === li);
        const record_max=Math.max(...list);
        target.forEach(t =>{
            record_max === parseInt(t.textContent)?t.classList.add("max"):"";
        })
    }
}

//dateの削除
async function tr_delete(target){
    const data=new FormData();
    data.append("record",target.dataset.id);
    if(!confirm("削除しますか？"))return;
    const res=await (await fetch("?action=tr_delete",{method:"POST",body:data})).json();
    if(!res){
        alert("削除できませんでした。");
        return;
    }
    target.remove();
    max_search();
}