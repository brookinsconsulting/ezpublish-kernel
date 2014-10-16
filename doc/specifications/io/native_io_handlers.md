
# Native IO handlers

Starting from versions 5.4 / 2013.09, a native IO handler is available. It is no longer necessary to use the default, LegacyKernel IO handler that uses legacy callbacks.

## IO interfaces split
The unique `IOHandler` interface is removed, in favour of two separate ones:
- `eZ\Publish\IO\IOMetadataHandler`: Stores & reads metadata (validity, size...)
- `eZ\Publish\IO\IOBinarydataHandler`: Stores & reads binarydata (actual contents)

The IOService uses both, and hasn't been modified (except for the minor API changes, see doc/bc/changes-5.4.txt).

## Configuration
Semantic configuration is now available for IO handling.

Which IO handlers (metadata & binarydata) is configurable by siteaccess. This is the default configuration:
```
ezpublish:
    system:
        default:
            io:
                metadata_handler: default
                binarydata_handler: default
```

metadata and binarydata handlers are configured in the `ez_io` extension. This is what the configuration would look like for the default handlers. It declares a metadata handler and a binarydata handler. Both are named 'default', are of type 'flysystem', and use the same flysystem adapter named default.

```
ez_io:
    metadata_handlers:
        default:
            flysystem:
                adapter: default
    binarydata_handlers:
        default:
            flysystem:
                adapter: default
```

The 'default' flysystem adapter (see below for details)'s directory is based on your site settings, and will automatically be set to `%ezpublish_legacy.root_dir%/$var_dir$/$storage_dir$` (example: `/path/to/ezpublish_legacy/var/ezdemo_site/storage`).

## The native Flysystem handler.
[league/flysystem](flysystem.thephpleague.com) (along with [FlysystemBundle](https://github.com/1up-lab/OneupFlysystemBundle/)) is an abstract file manipulation library.

It is used as the default way to read & write content binary files in eZ Publish. It can use the local filesystem (our default configuration), but is also able to read/write to sftp, zip or cloud filesystems (dropbox, rackspace, aws-s3).

### handler options
#### adapter
The adapter is the 'driver' used by flysystem to read/write files. Adapters can be declared using `oneup_flysystem` as follows:
```
oneup_flysystem:
    adapters:
        default:
            local:
                directory: "/path/to/directory"
```

How to configure other adapters can be found on the [bundle's online documentation](https://github.com/1up-lab/OneupFlysystemBundle/blob/master/Resources/doc/index.md#step3-configure-your-filesystems). Note that we do not use the Filesystems described in this documentation, only the adapters.

## Upgrading
For those using the default `eZFSFileHandler`, no configuration should be required, and things should just work like before, but without legacy kernel callbacks for manipulating images & binary files.
