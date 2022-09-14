var tJ017_TransModel = { keySize: 128 / 8, iv: null, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7 };

function JCNtAES128EncryptData(ptSrc, ptKey, ptIV) {
    try {
        tJ017_TransModel['iv'] = CryptoJS.enc.Utf8.parse(ptIV);

        return CryptoJS.AES.encrypt(CryptoJS.enc.Utf8.parse(ptSrc), CryptoJS.enc.Utf8.parse(ptKey), tJ017_TransModel).toString();
    } catch (oE) {
        throw new Error(J002_GETtFunctName(arguments) + ", " + oE.message + "\n");
    }
} //end

function JCNtAES128DecryptData(ptSrc, ptKey, ptIV) {
    try {
        tJ017_TransModel['iv'] = ptIV;
        var decrypted = CryptoJS.AES.decrypt(ptSrc, ptKey, tJ017_TransModel);
        var tRet = decrypted.toString(CryptoJS.enc.Utf8);
        return 'return:' + tRet;
    } catch (oE) {
        throw new Error(J002_GETtFunctName(arguments) + ", " + oE.message + "\n");
    }
} //

function J017_GETtTransKey(ptKey) {
    try {
        return CryptoJS.enc.Utf8.parse(ptKey);
    } catch (oE) {
        //
    }
} //end