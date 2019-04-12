# Sodium.NET/JWT


### Environment:
* Visual Studio 2017
* .NET framework 4.5
* C#
* Web forms
* Azure cloud service web role


### Prerequites
1. Install the libsodium .NET binding from nuget (using nuget.exe, not VS):
> nuget install libsodium-net -Version 0.10.0

2. To generate JWT, you have to install the official 
**System.IdentityModel.Tokens.Jwt** package. To do so:
> nuget install System.IdentityModel.Tokens.Jwt


### How To Build
1. Set target platform to 64 bits.
2. Build the solution.
3. Run the program (The first time might fail)
   If it fails with an error that says something like "file not found libsodium-64..."
   * Right click on the current project, "Add Existing Item".
   * Change File Type to "All Types".
   * Select "libsodium-64.dll" (the native lib) from sodium\lib\libsodium-net.0.10.0\output (This is not common, but that's how it works.)
   * Select the item you just added, right click, properties, and set the option 
   "Copy to Output Directory" to "Copy Always".

4. Build, and Run the program again. This time, it should work.


*Note: In this case is better **not** to use commands like "nuget restore" or stuff like that. When it comes to native libraries, it is better to handle 
references by hand.*

### Links
* Sodium-NET https://www.nuget.org/packages/libsodium-net/
* JWT https://www.nuget.org/packages/System.IdentityModel.Tokens.Jwt/
* HS256 https://stackoverflow.com/questions/39239051/rs256-vs-hs256-whats-the-difference




