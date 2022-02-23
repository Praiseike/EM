var error = {
    msg:[],
    count: 0,
    on: false
};

const validate = (e) => {
    e.preventDefault();
    password = $("#inputPassword")[0];
    password_confirm = $("#inputPasswordConfirm")[0];
    color = $("#title-help")[0].style.color;

    p_outline = password.style.border;
    c_outilne = password_confirm.style.border;
    console.log(p_outline,c_outilne);
    if(password.value.match('[0-9]') == null){
        error.count += 1;
    }

    if(password.value.length < 8)
    {
        error.count += 1;
    }
    if(password.value !== password_confirm.value){
        error.msg.count += 1;
        error.msg.push("passwords do not match");
    }

    if(error.count > 0)
    {
        $("#title-help")[0].style.color = "rgba(255,0,0,0.7)";
        password.style.outline = "4px solid rgba(255,0,0,0.4)";
        password_confirm.style.outline = "4px solid rgba(255,0,0,0.4)";
    }

    password_field = $("#password-field")[0];


    if(error.msg.length > 0){
    
        if(!error.on && error.msg.length > 0){
            error.on = true;
            div = document.createElement("div");
            div.classList.add("form-text");
            div.innerText = error.msg[0];
            div.style.color = "red";
            password_field.appendChild(div);
            setTimeout(() => {
                $("#title-help")[0].style.color = color;
                password_field.removeChild(div);
                error.on = false;
                error.count = 0;
                error.msg.pop();
                password.style.outline = '';
                password_confirm.style.outline = '';        
            },4000);
        }        
    }
    console.log(error.count);
    if(error.count === 0)
    {
        console.log("You are clear to go");
    }
}

const init = () => {
    form = $("form")[0];
    form.onsubmit = validate;
}
