import Glow from 'stimulus-glow';
import { app } from "../utils/firebase";
import { getAuth, GoogleAuthProvider, signInWithPopup } from "firebase/auth";

/* stimulusFetch: 'lazy' */
export default class extends Glow {
  connect() {
    super.connect();
    this.application.register('glow', Glow);
  }

  google() {
    const provider = new GoogleAuthProvider();
    const auth = getAuth(app);
    signInWithPopup(auth, provider)
      .then((result) => {
        console.log(result);

        window.location.href = window.location.href + "?token=" + result.user.accessToken;
      }).catch((error) => {
        // Handle Errors here.
        const errorCode = error.code;
        const errorMessage = error.message;
        // ...
        console.error(error);
      });
  }
}
