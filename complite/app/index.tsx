import { 
  Text,
  TextInput,
  TouchableOpacity,
  View, 
  StyleSheet,
  SafeAreaView,
} from "react-native";

export default function Index() {
  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.formContainer}>
        <Text style={styles.logo}>LOGO</Text>
        <Text style={styles.label}>Email/Username</Text>
        <TextInput
          style={styles.input}
          placeholder="Enter Email/Username"
        />
        <Text style={styles.label}>Password</Text>
        <TextInput
          style={styles.input}
          placeholder="Enter Password"
          secureTextEntry={true}
        />
        <TouchableOpacity style={styles.loginButton}>
          <Text style={styles.label}>Login</Text>
        </TouchableOpacity>
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
  },
  formContainer: {
    width: '70%',
    height: '50%',
    backgroundColor: 'darkgrey',
    padding: 20,
    borderRadius: 20,
    justifyContent: 'center',
  },
  logo: {
    textAlign: 'center',
    fontSize: 32,
    fontWeight: '600',
    color: 'white',
    marginBottom: 10,
  },
  label: {
    fontSize: 16,
    fontWeight: '400',
    color: 'white',
  },
  input: {
    fontSize: 16,
    color: 'gray',
    backgroundColor: 'white',
    marginBottom: 20,
    padding: 10,
    borderRadius: 10,
  },
  loginButton: {
    backgroundColor: 'brown',
    width: '30%',
    alignItems: 'center',
    padding: 10,
    alignSelf: 'center',
  }
});