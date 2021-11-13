import requests
import hashmac
import hashlib

endpoint = "https://payment-webinit.simu.sips-atos.com"

merchantId = "002001000000001"
secretKey = "002001000000001_KEY1"

interfaceVersion = "HP_2.39"

data = "amount=5500|currencyCode=978|merchantId=011223744550001|normalReturnUrl=http://www.normalreturnurl.com|transactionReference=534654|keyVersion=1"

params = {}

params["Data"] = data
params["Seal"] = hmac.new(secreyKey.encode("utf8"), msg = data.encode("utf8"))
params["InterfaceVersion"] = interfaceVersion

resp = requests.post(endpoint + "/paymentInit", data = params)

print(resp)
