document.querySelectorAll('.favorite_form').forEach((el) => {
    el.onsubmit = async (e) =>{
        e.preventDefault();
        let data = new FormData(e.target);
        
        let result = await fetch('./add_favorite.php', {
            method:"POST",
            body:data,
        });
        let resultParse = await result.json();
        
        if(!resultParse.flag)
            alert(resultParse.msg);
        else
            alert(resultParse.msg);
    }
})