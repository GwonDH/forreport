
1. 동적 웹페이지와 정적 웹페이지의 차이를 설명하시오.


정적 웹페이지
<br>
  서버에 미리 저장된 대로 전달<br>
  빠르고 비용이 적게 드나, 관리가 힘.<br>

동적 웹페이지
<br>
  서버에 있는 데이터들을 가공처리한 후 생성 및 전달되는 웹페이지<br>
  다양한 서비스를 제공할 수 있고 관리가 쉬우나, 느리고 추가 비용이 듬.<br>

<br>
<br>
  
2. PHP에 설치된 모듈(20개)은 어떤 것이 있는지 조사하시오.


  bcmath
  calendar
  Core
  ctype
  date
  dba
  dom
  ereg
  exif
  fileinfo
  filter
  ftp
  gd
  hash
  iconv
  json
  libxml
  mbstring
  mysql
  openssl
  pcre
  PDO
  pdo_sqlite
  Phar
  posix
  Reflection
  session
  SimpleXML
  sockets
  SPL
  SQLite
  sqlite3
  standard
  sysvsem
  sysvshm
  tokenizer
  wddx
  xml
  xmlreader
  xmlwriter
  zlib


<br>
<br>
 

3. PHP에서 사용되는 스크립트 엔진에 대해 기술하시오.
   

  Zend Engine(Open Source Script)<br>
  Zend Engine = 컴파일러+ 런타임 엔진, PHP에 의해 내부적으로 사용됨. <br>
  PHP 스크립트는 메모리로 전개, Zend opcode로 컴파일, opcode들이 실행된 이후 생성된 HTML은 클라이언트로 송신


<br>
<br>
 

4. 웹 브라우저에서 http://www.abc.com/abc.php 페이지를 접속했을 때, 서버는 어떠한 일을 수행하는가?


  PHP Parser -> Data 처리(필요 시 DataBase와 연동) -> Web Server가 웹 페이지의 로직과 처리 결과 받음 -> 받은 데이터들로 웹 페이지 완성<br>


<br>
<br>
 

5. call by value와 call by reference의 차이점에 대해 기술하시오.

  
  Call by Value = 일종의 복붙, 함수 내 값 변경 != 원본 값 변경<br>
  Call by Reference = 참조, 함수 내 변수 값 변경 = 원본 값 변경.<br>
