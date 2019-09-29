# -*- coding: utf-8 -*-

import nacl.utils
from nacl.public import PrivateKey,Box,PublicKey
import pytz
import datetime
import jwt
import os
import base64


from flask import Flask
from flask import flash
from flask import request
from flask import redirect
from werkzeug.utils import secure_filename

#Considered timezone
TZ = "US/Eastern"

def sassier_jwt():
    utc_now = pytz.utc.localize(datetime.datetime.utcnow())
    use_now = utc_now.astimezone(pytz.timezone(TZ))
    exp = use_now + datetime.timedelta(hours=2)
    payload = {
        "iat": use_now,
        "exp": exp,
        "id": "2123",#your user id
        "email": 'someth@add.com',#your email
        "token": os.getenv("TENANT_ID")  #your token
    }
    return jwt.encode(payload, os.getenv("JWT_SECRET") , algorithm='HS256') #'SAASLER JWT TOKEN'

app = Flask(__name__)

@app.route('/', methods=['GET'])

def serve():
    #Let's generate keys
    # private_key = PrivateKey.generate()
    # public_key  = private_key.public_key
    private_key = base64.b16decode("YOU CAN PASTE HERE SANDBOX PRIVATE KEY", True)
    public_key  = bytes.fromhex("YOU CAN PASTE HERE SANDBOX PUBLIC KEY")
    sassler_public_key = base64.b16decode(os.getenv("SAASLER_PUBLIC_NACL"), True)

    box = Box(PrivateKey(private_key), PublicKey(sassler_public_key))
    encrypted_message = box.encrypt(sassier_jwt(), nacl.utils.random(Box.NONCE_SIZE))

    out ='''
    <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Test</title>
  </head>

  <body>
  <div id="saasler-integrations" class="panel-body"></div>
  <!-- start Saasler -->
  <script type="text/javascript">
  ("undefined"==typeof window?global:window).__416c084fc49057a3260f322421d1699c=function(){var e={exports:{}},t=e.exports,n={module:e,exports:t},a=function(a){return function(r,o,i){var s,f,c="undefined"==typeof window?global:window,l=c.define;i=[i,o,r].filter(function(e){return"function"==typeof e})[0],o=[o,r,[]].filter(Array.isArray)[0],s=i.apply(null,o.map(function(e){return n[e]})),f=typeof s,"function"==typeof l&&l("string"==typeof r?r:a,o,i),"string"===f?s=String(s):"number"===f?s=Number(s):"boolean"===f&&(s=Boolean(s)),void 0!==s&&(t=e.exports=s)}}("__416c084fc49057a3260f322421d1699c");return a.amd=!0,function(e,n){if("function"==typeof a&&a.amd)a([],n);else if("undefined"!=typeof t)n();else{var r={exports:{}};n(),e.saasler_snippet=r.exports}}(this,function(){var e="https://saasler-production-static.s3.amazonaws.com/saasler.min.js",t="https://saasler-production-static.s3.amazonaws.com/saasler.min.css";!function(n,a){a.SV||!function(){var r=function(e){var t=n.createElement("script");t.type="text/javascript",t.async=!0,t.src=e;var a=n.getElementsByTagName("script")[0];a.parentNode.insertBefore(t,a)},o=function(e){var t=n.createElement("link");t.rel="stylesheet",t.type="text/css",t.href=e;var a=n.getElementsByTagName("script")[0];a.parentNode.insertBefore(t,a)};window.saasler=a,a.initParams=[],a.init=function(n,i,s){r(e),o(t),a.initParams=[n,i,s]},a.SV=1}()}(document,window.saasler||[])}),e.exports}.call(this);
  </script>
  <!-- end Saasler -->'''

    out += f'''
  <script type="text/javascript">
  saasler.init('{os.getenv("TENANT_ID")}','{encrypted_message.hex()}');
  </script>
  '''

    html_end ='''
  </body>
</html>
    '''
    return out + html_end

if __name__ == '__main__':
    app.run()