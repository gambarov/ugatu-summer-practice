import { createStore } from 'vuex'
import equipment from "./equipment.js"
import sets from "./sets.js"

export default createStore({
  state: {
  },
  modules: {
    equipment,sets
  }
})
