CREATE TABLE [lesion].[LESCON](
	[LESCONCOD] [int] IDENTITY(1,1) NOT NULL,
	[LESCONTIC] [int] NOT NULL,
    [LESCONPRC] [int] NOT NULL,
    [LESCONLEC] [int] NOT NULL,
	[LESCONRES] [char](1) NOT NULL,
	[LESCONOBS] [varchar](5120) NULL,
	[LESCONAUS] [char](50) NOT NULL,
	[LESCONAFH] [datetime] NOT NULL,
	[LESCONAIP] [char](20) NOT NULL,
 CONSTRAINT [PK_LESCONCOD] PRIMARY KEY CLUSTERED ([LESCONCOD] ASC) WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]) ON [PRIMARY]
GO

CREATE TABLE [lesion].[LESCONA](
    [LESCONAIDD] [int] IDENTITY(1,1) NOT NULL,
    [LESCONAMET] [char](20) NOT NULL,
	[LESCONAUSU] [char](50) NOT NULL,
	[LESCONAFEC] [datetime] NOT NULL,
	[LESCONADIP] [char](20) NOT NULL,
	[LESCONACOD] [int] NULL,
	[LESCONATIC] [int] NULL,
    [LESCONAPRC] [int] NULL,
    [LESCONALEC] [int] NULL,
	[LESCONARES] [char](1) NULL,
	[LESCONAOBS] [varchar](5120) NULL,
 CONSTRAINT [PK_LESCONAIDD] PRIMARY KEY CLUSTERED ([LESCONAIDD] ASC) WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]) ON [PRIMARY]
GO

ALTER TABLE [lesion].[LESCON] WITH CHECK ADD CONSTRAINT [FK_LESCON_LESCONTIC] FOREIGN KEY([LESCONTIC]) REFERENCES [adm].[DOMFIC] ([DOMFICCOD])
GO
ALTER TABLE [lesion].[LESCON] CHECK CONSTRAINT [FK_LESCON_LESCONTIC]
GO

ALTER TABLE [lesion].[LESCON] WITH CHECK ADD CONSTRAINT [FK_LESCON_LESCONPRC] FOREIGN KEY([LESCONPRC]) REFERENCES [adm].[DOMFIC] ([DOMFICCOD])
GO
ALTER TABLE [lesion].[LESCON] CHECK CONSTRAINT [FK_LESCON_LESCONPRC]
GO

ALTER TABLE [lesion].[LESCON] WITH CHECK ADD CONSTRAINT [FK_LESCON_LESCONLEC] FOREIGN KEY([LESCONLEC]) REFERENCES [lesion].[LESCON] ([LESFICCOD])
GO
ALTER TABLE [lesion].[LESCON] CHECK CONSTRAINT [FK_LESCON_LESCONLEC]
GO

CREATE TRIGGER [lesion].[LESCON_INSERT] 
	ON [lesion].[LESCON]
	AFTER INSERT
	AS
	BEGIN
		SET NOCOUNT ON;
		INSERT INTO [lesion].[LESCONA] (LESCONAMET, LESCONAUSU, LESCONAFEC, LESCONADIP, LESCONACOD, LESCONATIC, LESCONAPRC, LESCONALEC, LESCONARES, LESCONAOBS)
		SELECT 'INSERT AFTER', i.LESCONAUS, GETDATE(), i.LESCONAIP, i.LESCONCOD, i.LESCONTIC, i.LESCONPRC, i.LESCONLEC, i.LESCONRES, i.LESCONOBS FROM INSERTED i;
	END
GO

CREATE TRIGGER [lesion].[LESCON_UPDATE] 
	ON [lesion].[LESCON]
	AFTER UPDATE
	AS
	BEGIN
		SET NOCOUNT ON;
		INSERT INTO [lesion].[LESCONA] (LESCONAMET, LESCONAUSU, LESCONAFEC, LESCONADIP, LESCONACOD, LESCONATIC, LESCONAPRC, LESCONALEC, LESCONARES, LESCONAOBS)
        SELECT 'UPDATE BEFORE', d.LESCONAUS, GETDATE(), d.LESCONAIP, d.LESCONCOD, d.LESCONTIC, d.LESCONPRC, d.LESCONLEC, d.LESCONRES, d.LESCONOBS FROM DELETED d;

		INSERT INTO [lesion].[LESCONA] (LESCONAMET, LESCONAUSU, LESCONAFEC, LESCONADIP, LESCONACOD, LESCONATIC, LESCONAPRC, LESCONALEC, LESCONARES, LESCONAOBS)
        SELECT 'UPDATE AFTER', i.LESCONAUS, GETDATE(), i.LESCONAIP, i.LESCONCOD, i.LESCONTIC, i.LESCONPRC, i.LESCONLEC, i.LESCONRES, i.LESCONOBS FROM INSERTED i;
	END
GO

CREATE TRIGGER [lesion].[LESCON_DELETE] 
	ON [lesion].[LESCON]
	AFTER DELETE
	AS
	BEGIN
		SET NOCOUNT ON;
		INSERT INTO [lesion].[LESCONA] (LESCONAMET, LESCONAUSU, LESCONAFEC, LESCONADIP, LESCONACOD, LESCONATIC, LESCONAPRC, LESCONALEC, LESCONARES, LESCONAOBS)
        SELECT 'DELETE BEFORE', d.LESCONAUS, GETDATE(), d.LESCONAIP, d.LESCONCOD, d.LESCONTIC, d.LESCONPRC, d.LESCONLEC, d.LESCONRES, d.LESCONOBS FROM DELETED d;
	END
GO