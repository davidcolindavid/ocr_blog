document.querySelector("#tab_comments").addEventListener('click', function () {
    document.querySelector("#admin_container").style.transition = 'transform 0.3s' 
    document.querySelector("#admin_container").style.transform = 'translate3D(-50%,0,0)' 

    document.querySelector("#tab_line").style.transition = 'transform 0.3s' 
    document.querySelector("#tab_line").style.transform = 'translate3D(100%,0,0)' 
})

document.querySelector("#tab_posts").addEventListener('click', function () {
    document.querySelector("#admin_container").style.transition = 'transform 0.3s' 
    document.querySelector("#admin_container").style.transform = 'translate3D(0,0,0)' 

    document.querySelector("#tab_line").style.transition = 'transform 0.3s' 
    document.querySelector("#tab_line").style.transform = 'translate3D(0,0,0)' 
})


let tableDetails= document.querySelector(".table_title")

for (let i = 0; i < document.querySelector(".posts_table tbody").children.length; i++) {
    let ze = document.querySelector(".posts_table tbody").children[i]
    ze.addEventListener('click', function () {
        tableDetails.style.color = "#FFF"

    }) 
}

