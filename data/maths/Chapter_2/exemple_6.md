# Exemple 6 - Type BAC

Nicolas à installé 10 jeux sur sa console, 5 jeux d'aventures, 3 jeux de courses de voitures et 2 jeux sportif. Chaque week-end il choisit 5 jeux au hasard $\\$


1. Combien de choix possible chaque week-end ?

<section class="hidden">

L'ordre n'intervient pas.


On modélise la situation par des combinaisons de 5 éléments parmi 10. $\\$

On a :

$$
    \begin{pmatrix}
    10 \\
    5 
    \end{pmatrix} = \frac {10!}{5!(10-5)!} = \frac {10!}{5!5!} = \frac {10\times9\times8\times7\times6\times5!}{5\times4\times3\times2\times5!} = 3\times2\times7\times6 = 252
$$

</section>

2. Combien de ces choix comportent-ils exactement 2 jeux de voiture ?


<section class="hidden">

L'ordre n'intervient pas.

On modélise la situation par des combinaisons de 2 éléments parmi 3 ET des combinaisons de 3 éléments parmi 7. $\\$

On a :

$$
    \begin{pmatrix}
    3 \\
    2 
    \end{pmatrix} \times
    \begin{pmatrix}
    7 \\
    3 
    \end{pmatrix} = \frac {3!}{2!(3-2)!} \times \frac{7!}{3!4!} = \frac{3\times2!}{2!} \times \frac {7\times6\times5\times4!}{3!4!} = 3 \times \frac{7\times6\times5}{6} =3\times7\times5 = 105
$$

</section>

