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
            console.log(resultParse.msg);
        else
            
            console.log(resultParse);
    }
})