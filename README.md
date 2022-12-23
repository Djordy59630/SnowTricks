Dernière analyse Codacy <br/>
----------------------- <br/>

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/e18811bd7b1542f581f0853c726d1e53)](https://www.codacy.com/gh/Djordy59630/SnowTricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Djordy59630/SnowTricks&amp;utm_campaign=Badge_Grade) <br/>

--------------------- <br/>
Instruction <br/>
--------------------- <br/>


Php version : 8.01 <br/>
MariaDb : 10.6.5-MariaDB

I For init project : <br/>
  ------------------------- <br/>
  1 - Clone this repository <br/>
  2 - composer install  <br/>
  3 - yarn install  <br/>
  4 - yarn build  <br/><br/>


II For Database <br/>
  ------------------------ <br/>
   1 - modify .env with database informations <br/>
   2 - php bin/console doctrine:database:create <br/>
   3 - php bin/console doctrine:migrations:migrate <br/>
   
   
III For Fixtures <br/>
  ----------------------- <br/>
  1 - php bin/console doctrine:fixtures:load <br/><br/>
  
IV For local environement <br/>
  ----------------------- <br/>
  1 - Configurer le mailer dns en fonction de votre environement local
  
  Account : Michel <br/> 
  Password : MonSuperMotDePasse. <br/><br/>
  
  Enjoy :D
