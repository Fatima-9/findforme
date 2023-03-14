
    // La méthode addEventListener() de EventTarget attache une fonction à appeler 
    // chaque fois que l'évènement spécifié est envoyé à la cible
    
    document.forms.register.addEventListener("submit", function(event){
        event.preventDefault()
        let erreur = ""
       
        document.forms.register.password.style.border=""
        document.forms.register.tel.style.border=""

    // LES CONDITIONS DE MON FORMULAIRE 

    // Documents.forms : pour Récupérer les informations d'un formulaire dans mon fichier HTML
      
    
       if(!document.forms.register.password.value.match(/(?=.*?[A-Z])(?=(?:\D*\d){3}).{8,}/)){
            document.forms.register.password.style.border="1px solid red"
            erreur += "<div class='alert alert-danger' role='alert'>Erreur : Mot de passe incorrect </div>"
          
        }
        if(document.forms.register.tel.value.length!= 10){
            document.forms.register.tel.style.border="1px solid red"
            erreur += "<div class='alert alert-danger' role='alert'>Erreur : Numéro de téléphone incorrect </div>"
          
        }
        
        // La méthode getElementById() de Document renvoie un objet Element représentant 
        // l'élément dont la propriété id correspond à la chaîne de caractères spécifiée.


        document.getElementById("resultat").innerHTML = erreur
        document.getElementById("resultat").style.width = event.target.value+"px"


        if(erreur==""){

            // alert("inscption reussi")
            event.currentTarget.submit();

        }
    })

 