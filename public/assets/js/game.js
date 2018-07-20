var cardsLabels = ["Parc des Buttes Chaumont","Le châlet des îles", "Le bois de Boulogne","Parc Montsouris","La tour Eiffel", "Le parc Monceau"];
var nbClics = 0,
    coups =0,
    carte1 = "",
    carte2="",
    case1 = "",
    case2 ="",
    imgOk =0,
    points =0,
    paireTrouvee = 20,
    paireNonTrouvee = 10,
    depart= false,
    temps_debut = new Date().getTime();
var url = window.location.host;

generation();

for(var i=0;i<6;i++)
{
    document.getElementById('img' +i).src='/assets/img_memory/Back.jpg';
}
depart=true;

function generation()
{
    var nb_alea,
        nb_img="",
        test = true,
        chaine = "";

    for (var i=0;i<6;i++)
    {
        while (test===true)
        {
            nb_alea = Math.floor(Math.random()*6) + 1;
            if(chaine.indexOf("-" + nb_alea + "-")>-1)
                nb_alea = Math.floor(Math.random()*6) + 1;
            else
            {
                nb_img = Math.floor((nb_alea+1)/2);
                document.getElementById('case' + i).innerHTML = "<img class='img-thumbnail img-fluid' style='cursor:pointer;' id='img" + i + "' src=" + nb_img + "'/assets/img_memory/carte.jpg' onClick='verifier(\"img" + i + "\", \"carte" + nb_img + "\")' alt='' />";
                chaine += "-" + nb_alea + "-";
                test=false;
            }
        }
        test=true;
    }
}

function verifier(limg,source)
{
    if(depart===true)
    {
        nbClics++;
        document.getElementById(limg).src='/assets/img_memory/'+source+'.jpg';

        if(nbClics ===1)
        {
            carte1=source;
            case1=limg;
        }
        else
        {
            carte2=source;
            case2=limg;
            if(case1!==case2)
            {
                depart=false;
                if(carte1!==carte2)
                {
                    attente =setTimeout(function()
                    {
                        document.getElementById(case1).src='/assets/img_memory/Back.jpg';
                        document.getElementById(case2).src='/assets/img_memory/Back.jpg';
                        depart=true;
                        nbClics=0;
                        coups++;
                        points = points - paireNonTrouvee;
                     //   document.getElementById('coups').innerHTML='<p>Nombre de clics : <strong>'+coups+'</strong></p>';

                    },800);
                }
                else
                {
                    depart=true;
                    nbClics=0;
                    coups++;
                    points= points + paireTrouvee;
                  //  document.getElementById('coups').innerHTML='<p>Nombre de clics :<strong>'+coups+'</strong></p>';
                    imgOk +=2;
                  //  document.getElementById('paireOk').innerHTML='<p>Vous avez trouvé <strong>'+imgOk/2+'</strong> paire(s) ! </p>';
                    document.getElementById('noms').innerHTML='<p>Bravo ! Vous avez trouvé  :  <strong>'+cardsLabels[Number(carte1.replace(/[^\d]/g, ""))-1]+'</strong></p>';

                    if(imgOk===6)
                    {
                       window.location = '/inscription';
                    }
                }
            }
            else
            {
                if(nbClics===2)nbClics=1;
            }
        }
    }
}


