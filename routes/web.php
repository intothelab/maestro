<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Geocoder\Laravel\Facades\Geocoder;

$nfe = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><nfeProc versao=\"4.00\" xmlns=\"http://www.portalfiscal.inf.br/nfe\"><NFe xmlns=\"http://www.portalfiscal.inf.br/nfe\"><infNFe Id=\"NFe35190922005991000138550010000028841083090006\" versao=\"4.00\"><ide><cUF>35</cUF><cNF>08309000</cNF><natOp>REMESSA PARA IND POR CONTA E ORDEM DE TERC</natOp><mod>55</mod><serie>1</serie><nNF>2884</nNF><dhEmi>2019-09-19T14:32:00-03:00</dhEmi><tpNF>1</tpNF><idDest>2</idDest><cMunFG>3550308</cMunFG><tpImp>1</tpImp><tpEmis>1</tpEmis><cDV>6</cDV><tpAmb>1</tpAmb><finNFe>1</finNFe><indFinal>0</indFinal><indPres>0</indPres><procEmi>3</procEmi><verProc>4.01_sebrae_b026</verProc></ide><emit><CNPJ>22005991000138</CNPJ><xNome>SIGMAPRINT EMBALAGENS EIRELI</xNome><xFant>SIGMAPRINT</xFant><enderEmit><xLgr>RUA BICAS</xLgr><nro>97</nro><xBairro>CIDADE IND. SATELITE</xBairro><cMun>3550308</cMun><xMun>Sao Paulo</xMun><UF>SP</UF><CEP>07223040</CEP><cPais>1058</cPais><xPais>BRASIL</xPais></enderEmit><IE>796311620115</IE><CRT>1</CRT></emit><dest><CNPJ>05679171000102</CNPJ><xNome>JALL CARDS - CARTOES E SERVIÇOS LTDA</xNome><enderDest><xLgr>RUA AMALIA STRAPASSON DE SOUZA</xLgr><nro>398</nro><xBairro>MAUA</xBairro><cMun>4105805</cMun><xMun>Colombo</xMun><UF>PR</UF><CEP>83413560</CEP><cPais>1058</cPais><xPais>BRASIL</xPais><fone>4136757773</fone></enderDest><indIEDest>1</indIEDest><IE>9034724056</IE><email>barbara@jallcard.com.br</email></dest><det nItem=\"1\"><prod><cProd>SGM IDEZ</cProd><cEAN/><xProd>SACO ENVELOPE 12X17+3 ABA</xProd><NCM>39232110</NCM><CFOP>6924</CFOP><uCom>UNI</uCom><qCom>8100.0000</qCom><vUnCom>0.4800000000</vUnCom><vProd>3888.00</vProd><cEANTrib/><uTrib>UNI</uTrib><qTrib>8100.0000</qTrib><vUnTrib>0.4800000000</vUnTrib><indTot>1</indTot></prod><imposto><ICMS><ICMSSN102><orig>0</orig><CSOSN>400</CSOSN></ICMSSN102></ICMS><IPI><cEnq>999</cEnq><IPITrib><CST>99</CST><vBC>0.00</vBC><pIPI>0.0000</pIPI><vIPI>0.00</vIPI></IPITrib></IPI><PIS><PISOutr><CST>99</CST><vBC>0.00</vBC><pPIS>0.0000</pPIS><vPIS>0.00</vPIS></PISOutr></PIS><COFINS><COFINSOutr><CST>99</CST><vBC>0.00</vBC><pCOFINS>0.0000</pCOFINS><vCOFINS>0.00</vCOFINS></COFINSOutr></COFINS></imposto></det><total><ICMSTot><vBC>0.00</vBC><vICMS>0.00</vICMS><vICMSDeson>0.00</vICMSDeson><vFCPUFDest>0.00</vFCPUFDest><vICMSUFDest>0.00</vICMSUFDest><vICMSUFRemet>0.00</vICMSUFRemet><vFCP>0.00</vFCP><vBCST>0.00</vBCST><vST>0.00</vST><vFCPST>0.00</vFCPST><vFCPSTRet>0.00</vFCPSTRet><vProd>3888.00</vProd><vFrete>0.00</vFrete><vSeg>0.00</vSeg><vDesc>0.00</vDesc><vII>0.00</vII><vIPI>0.00</vIPI><vIPIDevol>0.00</vIPIDevol><vPIS>0.00</vPIS><vCOFINS>0.00</vCOFINS><vOutro>0.00</vOutro><vNF>3888.00</vNF><vTotTrib>0.00</vTotTrib></ICMSTot></total><transp><modFrete>1</modFrete><transporta><CNPJ>90863325000352</CNPJ><xNome>TRANSPORTES RODOVIA SUL LTDA</xNome><IE>148686223114</IE><xEnder>RUA SOLDADO JOSE REYMÃO, 105</xEnder><xMun>Sao Paulo</xMun><UF>SP</UF></transporta><vol><qVol>3</qVol><esp>VOLUMES</esp><pesoL>16.000</pesoL><pesoB>16.000</pesoB></vol></transp><pag><detPag><indPag>1</indPag><tPag>90</tPag><vPag>0.00</vPag></detPag></pag><infAdic><infAdFisco>MERCADORIA SEGUE P/ FINS DE MANUSEIO POR CONTA E ORDEM DO ADIQUIRENTE IDEZ ADMINISTRACAO DE MEIOS DE PAGAMENTOS DIGITAL LTDA, LOC NA RUA HENRIQUE DIAS, 220 - APTO 09 - BOM FIM - PORTO ALEGRE /RS DO CNPJ 33652365/0001-506 CONSTANTE NA NOTA FISCAL DE VENDA 2883 (RIPI/2010, ART 491, I RICMS - SP/2000, ART 406 I).</infAdFisco></infAdic><infRespTec><CNPJ>43728245000142</CNPJ><xContato>suporte</xContato><email>suporteemissores@sebraesp.com.br</email><fone>08005700800</fone></infRespTec></infNFe><Signature xmlns=\"http://www.w3.org/2000/09/xmldsig#\"><SignedInfo><CanonicalizationMethod Algorithm=\"http://www.w3.org/TR/2001/REC-xml-c14n-20010315\"/><SignatureMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#rsa-sha1\"/><Reference URI=\"#NFe35190922005991000138550010000028841083090006\"><Transforms><Transform Algorithm=\"http://www.w3.org/2000/09/xmldsig#enveloped-signature\"/><Transform Algorithm=\"http://www.w3.org/TR/2001/REC-xml-c14n-20010315\"/></Transforms><DigestMethod Algorithm=\"http://www.w3.org/2000/09/xmldsig#sha1\"/><DigestValue>sZPhsalg93QQDWo461GXuHd8qZg=</DigestValue></Reference></SignedInfo><SignatureValue>eVsCMiUUl4MXM0JBcfG4NzBYUWeWqSA+zri3MnCa7pj/oDcUlOhDqI9jckLlyQfk47gkJa06d0k1
y3C5wdvdRu0wITtzwzmHVHF6aW+WLwAT2fBLEtI7OfzHaPnKeLphnjqQMjqf5itBfFmvVdumo9aX
0lZkxgBKXqj8KwHWhS/tJaTHNyGInIGZw1UlCzQThnTVESyvWvVX9v/3KRTGXBkhREVBARImG5vq
HLZaKlBw2lO9knbQbh1TglOhxSNVaFx43rcTpKue6mPO0g+Hofvs4c5uq3yrbjdk9TPoEfIqpNMs
CRGOtf72VcKlkh9w2uta9Ewtv8WypQkBEuhA8Q==</SignatureValue><KeyInfo><X509Data><X509Certificate>MIIH/TCCBeWgAwIBAgIQOBvDXuZjva3daAYYeVzjdjANBgkqhkiG9w0BAQsFADB4MQswCQYDVQQG
EwJCUjETMBEGA1UEChMKSUNQLUJyYXNpbDE2MDQGA1UECxMtU2VjcmV0YXJpYSBkYSBSZWNlaXRh
IEZlZGVyYWwgZG8gQnJhc2lsIC0gUkZCMRwwGgYDVQQDExNBQyBDZXJ0aXNpZ24gUkZCIEc1MB4X
DTE5MDUwOTE4MjA1NloXDTIwMDUwODE4MjA1NlowgeIxCzAJBgNVBAYTAkJSMRMwEQYDVQQKDApJ
Q1AtQnJhc2lsMQswCQYDVQQIDAJTUDESMBAGA1UEBwwJR3VhcnVsaG9zMTYwNAYDVQQLDC1TZWNy
ZXRhcmlhIGRhIFJlY2VpdGEgRmVkZXJhbCBkbyBCcmFzaWwgLSBSRkIxFjAUBgNVBAsMDVJGQiBl
LUNOUEogQTExFzAVBgNVBAsMDjE3MzM0MTE1MDAwNjIwMTQwMgYDVQQDDCtTSUdNQVBSSU5UIEVN
QkFMQUdFTlMgRUlSRUxJOjIyMDA1OTkxMDAwMTM4MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIB
CgKCAQEArKst2qhtfAe8rzQjvF1A8PsD5tboRDXnykmjFsA1E53FplMjCOUqSBCIdNBEyNCx/xDJ
+uniNV6MIMNR8DTCnIVg28iU2Lru+lTn4PTlAxm1ehq/5EOWxhQezOt563q6CadqouBRKVcU3+5W
uu6h2ksOuhSB59bDK5g1GGdsV3CTTVSDuxND54rbCrH6JoM/VAGLFEvPKxRz5vLnPPG9Mkr4jpan
dKeaze4ERirdUfsQ2dNO4ifPvsbc3wnNk9GaSv8ead4hGicfu4PQBwwO33iIspp7/q3YASMWXRC8
J8Chpe4wLpkqLIZ7Kx/uKDCL1A8PL7GbhWHWFCFKm2fqgwIDAQABo4IDFjCCAxIwgcUGA1UdEQSB
vTCBuqA9BgVgTAEDBKA0BDIyMzAxMTk2ODEwNzAwMTMzODI4MDAwMDAwMDAwMDAwMDAwMDAwMTg4
Mzc3MjRTU1BTUKAhBgVgTAEDAqAYBBZBREVJTFRPTiBBTFZFUyBBTE1FSURBoBkGBWBMAQMDoBAE
DjIyMDA1OTkxMDAwMTM4oBcGBWBMAQMHoA4EDDAwMDAwMDAwMDAwMIEiZmVybmFuZGFAZXNjcml0
b3Jpb3JlYmVjY2hpLmNvbS5icjAJBgNVHRMEAjAAMB8GA1UdIwQYMBaAFFN9f52+0WHQILran+OJ
pxNzWM1CMH8GA1UdIAR4MHYwdAYGYEwBAgEMMGowaAYIKwYBBQUHAgEWXGh0dHA6Ly9pY3AtYnJh
c2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vZHBjL0FDX0NlcnRpc2lnbl9SRkIvRFBD
X0FDX0NlcnRpc2lnbl9SRkIucGRmMIG8BgNVHR8EgbQwgbEwV6BVoFOGUWh0dHA6Ly9pY3AtYnJh
c2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vbGNyL0FDQ2VydGlzaWduUkZCRzUvTGF0
ZXN0Q1JMLmNybDBWoFSgUoZQaHR0cDovL2ljcC1icmFzaWwub3V0cmFsY3IuY29tLmJyL3JlcG9z
aXRvcmlvL2xjci9BQ0NlcnRpc2lnblJGQkc1L0xhdGVzdENSTC5jcmwwDgYDVR0PAQH/BAQDAgXg
MB0GA1UdJQQWMBQGCCsGAQUFBwMCBggrBgEFBQcDBDCBrAYIKwYBBQUHAQEEgZ8wgZwwXwYIKwYB
BQUHMAKGU2h0dHA6Ly9pY3AtYnJhc2lsLmNlcnRpc2lnbi5jb20uYnIvcmVwb3NpdG9yaW8vY2Vy
dGlmaWNhZG9zL0FDX0NlcnRpc2lnbl9SRkJfRzUucDdjMDkGCCsGAQUFBzABhi1odHRwOi8vb2Nz
cC1hYy1jZXJ0aXNpZ24tcmZiLmNlcnRpc2lnbi5jb20uYnIwDQYJKoZIhvcNAQELBQADggIBAGYQ
zH9/1UsA8PX0N+LKlbZ9CSFMJBzF8UwtCXTd12OqDODocr3zYyWjdbUElMKh/4I/cL1ByOkydCq5
wU8Eohf0KmkV7+iVLLCd3/rDVbYiqgmMdkcnwFg4aY+6pXbrHD3jicsFLXZPy77ffYeLc5D5HyKU
vedWbUV22EEAOxTVkwxEYP5kBPmLeP065u1wk2AwW4VQ+AatsSEN4Z7isjISxIKyyYNesveRmR+o
Hd6QUXTSy++jcdonehJWMAiQGo7L0Mp994sES4j0zP9bqgtJzU4MELr7ZTaxZhfCD0OO1MB4R9wf
ZJo34n1gv4H0yBziqVDO4CTvrNQ37tNioU99ZUeDpHlIt/3lhXPQtWyKs9O24oJJdaUwiYJNwpNd
Ovrpxyrxs78S9Q6+/yeLhrmL+lh3bfKv2h9c/Exrp4p8tKkyCkUFG6pcj64HUO7Cmf4LXB0EbyTZ
MW0bblLrzQ9QyY/lmeXlLavRSzNdtSLnR/3jTPwlU519OGjoc8+av7lwuYbEtiHuyH5yDAjMCxK1
k+xpILuHzcChxCVPeDXkITDABN4wUFqKH19iJe4MHbGkTnjTDh+7z/bgnJ+kesQM1cD9fPzfCNB1
Do7MSAsjZCsz08IP/yt0ft7BZnyX+4UtgW6Ds4i9SeRq3EIpsUr4GeGdLZhkcF1cZPuULKFp</X509Certificate></X509Data></KeyInfo></Signature></NFe><protNFe versao=\"4.00\"><infProt><tpAmb>1</tpAmb><verAplic>SP_NFE_PL009_V4</verAplic><chNFe>35190922005991000138550010000028841083090006</chNFe><dhRecbto>2019-09-19T15:20:02-03:00</dhRecbto><nProt>135190689653198</nProt><digVal>sZPhsalg93QQDWo461GXuHd8qZg=</digVal><cStat>100</cStat><xMotivo>Autorizado o uso da NF-e</xMotivo></infProt></protNFe></nfeProc>";

