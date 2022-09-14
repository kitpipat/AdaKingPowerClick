var tJ017_TransModel = { keySize: 128 / 8, iv: null, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7 };

function JCNtAES128EncryptData(ptSrc, ptKey, ptIV) {
    try {
        tJ017_TransModel['iv'] = CryptoJS.enc.Utf8.parse(ptIV);

        return CryptoJS.AES.encrypt(CryptoJS.enc.Utf8.parse(ptSrc), CryptoJS.enc.Utf8.parse(ptKey), tJ017_TransModel).toString();
    } catch (oE) {
        throw new Error(J002_GETtFunctName(arguments) + ", " + oE.message + "\n");
    }
} //end

// JCNtAES128DecryptData('QWRtaW4=','5YpPTypXtwMML$u@','zNhQ$D%arP6U8waL')
// JCNtAES128DecryptData('Ha9uaphyZh2LyKEwNrDG+A==','5YpPTypXtwMML$u@','zNhQ$D%arP6U8waL')
function JCNtAES128DecryptData(ptSrc, ptKey, ptIV) {
    try {
        tJ017_TransModel['iv'] = CryptoJS.enc.Utf8.parse(ptIV);
        var decrypted   = CryptoJS.AES.decrypt(ptSrc, CryptoJS.enc.Utf8.parse(ptKey), tJ017_TransModel);
        decrypted       = decrypted.toString(CryptoJS.enc.Utf8);
        return decrypted;
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